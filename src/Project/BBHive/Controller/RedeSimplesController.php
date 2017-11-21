<?php

namespace Project\BBHive\Controller;

use DoctrineProxy\__CG__\Project\Core\Entity\BbhDepartamento;
use Project\Core\Controller\AbstractController;
use Project\Core\Entity\BbhModeloFluxo;
use Project\Core\Entity\BbhProtocolos;
use Project\Core\Entity\BbhUsuario;
use Project\Core\Exception\Error;
use Project\Core\Helper\HttpHelper;
use Project\Core\Helper\ResponseHelper;
use Project\Core\Helper\StringHelper;
use Project\Core\Model\BBHive\BbhModeloFluxoModel;
use Project\Core\Model\BBHive\BbhProtocolosModel;
use Project\Core\Model\BBHive\BbhUsuarioModel;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class RedeSimplesController extends AbstractController implements ControllerProviderInterface
{
    /**
     * Variável responsável pela recuperação do formulário e todos os seus campos
     */
    const INTEGRATION_DYNAMIC_FORM = 'rede-simples';

    /**
     * Returns routes to connect to the given application
     * @param Application $app An Application instance
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        /**
         * @var \Silex\ControllerCollection $factory
         */
        $factory = $app['controllers_factory'];

        $factory->get('/form', $this->setRoute('getDynamicFormAction'));
        $factory->post('/form', $this->setRoute('setDynamicFormAction'));
        $factory->post('/protocol', $this->setRoute('protocolAction'));

        // ... Other routes
        return $factory;
    }

    /**
     * Return form active
     * @param \Silex\Application $app
     */
    public function getDynamicFormAction(Application $app)
    {
        $this->setUp($app);

        $fluxoModel = new BbhModeloFluxoModel($this->em);

        // Por enquanto somente os campos de protocolos estação envolvidos
        /*$formFields = $fluxoModel->getDynamicFieldsByDefaultValue(
            self::INTEGRATION_DYNAMIC_FORM,
            $allFieldsAvailable = true,
            $this->security
        );*/
        $protocoloFields = $fluxoModel->getDynamicFieldsProtocolo();

        $form = ['form' => []];
//        $form['form']['action'] = sprintf('%s/api/servicos/bbhive/rede-simples/form', StringHelper::parseAddressHttp($this->currentHost));
//        $form['form']['method'] = 'POST';
        $form['form']['fields'] = $protocoloFields;

        return ResponseHelper::response($form, HttpHelper::HTTP_STATUS_OK);
    }

    /**
     * @param \Silex\Application $app
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return string
     */
    public function setDynamicFormAction(Application $app, Request $request)
    {
        $this->setUp($app);

        // Por enquanto somente os campos de protocolos estação envolvidos
        $fluxoModel = new BbhModeloFluxoModel($this->em);
        /*$formFields = $fluxoModel->getDynamicFieldsByDefaultValue(
            self::INTEGRATION_DYNAMIC_FORM,
            $allFieldsAvailable = true,
            $this->security,
            $request->request
        );*/
        $this->parseRequest($request);
        $protocoloFields = $fluxoModel->getDynamicFieldsProtocolo($request->request);
        //$formData = array_merge($protocoloFields, $formFields);

        // Validate form
        $this->validateFormRequest($app, $request, $protocoloFields);

        $protocoloModel = new BbhProtocolosModel($this->em);
        $codProtocolo = $protocoloModel->createProtocolo($this->user, $protocoloFields);

        $response = ['response' => ['protocol' => $codProtocolo]];
        return ResponseHelper::response($response, HttpHelper::HTTP_STATUS_OK);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function parseRequest(Request $request)
    {
        $inputData = file_get_contents("php://input");
        if (!empty($inputData)) {
            $parameters = json_decode($inputData, true);
            foreach ($parameters as $parameter => $value) {
                $request->request->set($parameter, $value);
            }
        }

        return $request;
    }

    /**
     * @param \Silex\Application $app
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return string
     */
    public function protocolAction(Application $app, Request $request)
    {
        $this->setUp($app);
        $this->parseRequest($request);
        $codProtocol = $request->request->get('protocol');

        if (empty($codProtocol)) {
            $response = ['response' => ['message' => Error::INVALID_PARAMETERS]];
            return ResponseHelper::response($response, HttpHelper::HTTP_STATUS_BAD_GATEWAY);
        }

        $protocoloModel = new BbhProtocolosModel($this->em);
        $protocol = $protocoloModel->getProtocol($codProtocol);
        if (empty($protocol)) {
            $response = ['response' => ['message' => Error::PROTOCOL_NOT_FOUND]];
            return ResponseHelper::response($response, HttpHelper::HTTP_STATUS_OK);
        }

        // Valores do detalhamento
        $valuesProtocol = $protocoloModel->getDetailProtocol($protocol);

        // Campos do detalhamento
        $fieldsDetailProtocol = $protocoloModel->getFieldsDetailProtocol();

        // Protocolo em array
        $valuesDetailprotocol = $protocoloModel->getProtocolToArray($protocol);
        $valuesProtocol = array_merge($valuesProtocol, $valuesDetailprotocol);

        $status = BbhProtocolos::getStatusAvailable();
        $depto = $app['db.orm.em']->getRepository(\Project\Core\Entity\BbhDepartamento::class)->findOneByBbhDepCodigo($valuesProtocol['bbh_dep_codigo']);


        // Fluxo
        $workflow = $protocoloModel->getWorkflowByProtocol($protocol);
        $detailWorkflow = $fieldsWorkflow = null;
        if (!empty($workflow)) {
            $bbhFluxo = $app['db.orm.em']->getRepository(\Project\Core\Entity\BbhFluxo::class)->findOneByBbhFluCodigo($valuesProtocol['bbh_flu_codigo']);
            $valuesProtocol = array_merge($valuesProtocol, $protocoloModel->getDetailWorkflowByFluxo($bbhFluxo));
            $fieldsWorkflow = $protocoloModel->getFieldsDetailWorkflowByFluxo($bbhFluxo);

            foreach($fieldsWorkflow as $fieldWorkflow) {
                array_push($fieldsDetailProtocol, $fieldWorkflow);
            }
        }

        $fields = [];
        foreach ($fieldsDetailProtocol as $field) {
            if ((isset($field['bbh_cam_det_pro_nome']) && $field['bbh_cam_det_pro_nome'] == 'bbh_pro_status') ||
                (isset($field['bbh_cam_det_pro_nome']) && $field['bbh_cam_det_pro_nome'] == 'bbh_pro_identificacao')) {
                continue;
            }

            $fieldName = isset($field['bbh_cam_det_pro_nome']) ? $field['bbh_cam_det_pro_nome'] : $field['bbh_cam_det_flu_nome'];
            $type = isset($field['bbh_cam_det_pro_tipo']) ? $field['bbh_cam_det_pro_tipo'] : $field['bbh_cam_det_flu_tipo'];
            $label = isset($field['bbh_cam_det_pro_titulo']) ? $field['bbh_cam_det_pro_titulo'] : $field['bbh_cam_det_flu_titulo'];

            $defaultValue =  $valuesProtocol[$fieldName];
            if (isset($field['bbh_cam_det_pro_nome']) && $field['bbh_cam_det_pro_nome'] == 'bbh_pro_flagrante') {
                $defaultValue = in_array($defaultValue, ['N', 0, '0']) ? "Não" : "Sim";
            }

            $fields[] = [
                'name' => $fieldName,
                'label' => $label,
                'data' => isset($field['bbh_cam_det_pro_nome']) && $field['bbh_cam_det_pro_nome'] == 'bbh_dep_codigo' ?
                    $depto->getBbhDepNome():
                    StringHelper::parseDataFromType($type, $defaultValue)
            ];
        }

        $response = [
            'response' => [
                'message' => $valuesProtocol['bbh_pro_identificacao'],
                'status' => mb_strtoupper($status[$valuesProtocol['bbh_pro_status']]),
                'fields' => $fields
            ]
        ];
        return ResponseHelper::response($response, HttpHelper::HTTP_STATUS_OK);
    }

    /**
     * @param \Silex\Application $app
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    protected function validateFormRequest(Application $app, Request $request, $formFields)
    {
        // validate
        if (empty($request->request->get('csrf_token'))) {
            //return ResponseHelper::response(Error::INVALID_PARAMETERS, HttpHelper::HTTP_STATUS_BAD_GATEWAY);
        }

        if (isset($formFields['errors']) && !empty($formFields['errors'])) {
            return ResponseHelper::response($formFields['errors'], HttpHelper::HTTP_STATUS_BAD_GATEWAY);
        }
    }

    public function getAll(Application $app)
    {
        // Exemplo Usando model
        $modelUsuario = new BbhUsuarioModel($app['db.orm.em']);

        $totalUsuarios = count($modelUsuario->getAllUsersToJson());

        // Usando direto o Repository
        $totalFluxo = $app['db.orm.em']->getRepository(BbhModeloFluxo::class)->findAll();

        return ResponseHelper::response(['totalUsuarios' => $totalUsuarios, 'totalModeloFluxos' => count($totalFluxo)], HttpHelper::HTTP_STATUS_OK);
    }
}
