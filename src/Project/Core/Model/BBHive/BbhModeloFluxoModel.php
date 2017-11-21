<?php

namespace Project\Core\Model\BBHive;

use Project\Core\Entity\BbhCampoDetalhamentoFluxo;
use Project\Core\Exception\Error;
use Project\Core\Helper\ArrayHelper;
use Project\Core\Model\AbstractModel;
use Doctrine\ORM;
use Project\Core\Security\SecurityPassword;
use Respect\Validation\Validator as v;
use Symfony\Component\HttpFoundation\ParameterBag;

class BbhModeloFluxoModel extends AbstractModel
{
    protected $campoDetalhamentoRepository;

    protected $campoListaDinamicaRepository;

    protected $campoDetalhamentoProtocoloRepository;

    /**
     * BbhModeloFluxoModel constructor.
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('Project\Core\Entity\BbhModeloFluxo');

        $this->campoDetalhamentoRepository = $this->entityManager->getRepository('Project\Core\Entity\BbhCampoDetalhamentoFluxo');
        $this->campoDetalhamentoProtocoloRepository = $this->entityManager->getRepository('Project\Core\Entity\BbhCampoDetalhamentoProtocolo');
        $this->campoListaDinamicaRepository = $this->entityManager->getRepository('Project\Core\Entity\BbhCampoListaDinamica');
    }

    /**
     * @param $nameDefaultValue
     * @return mixed
     */
    protected function getTableNameDynamicDefaultValue($nameDefaultValue)
    {
        return $this->campoDetalhamentoRepository->findOneByBbhCamDetFluDefault($nameDefaultValue);
    }

    /**
     * @param \Project\Core\Entity\BbhCampoDetalhamentoFluxo $bbhCampoDetalhamentoFluxo
     * @param bool $allFields
     * @param null $security
     * @param null $formRequest
     * @return array
     */
    protected function mountListDynamicForm(
        BbhCampoDetalhamentoFluxo $bbhCampoDetalhamentoFluxo,
        $allFieldsAvailable = true,
        $security,
        ParameterBag $formRequest = null)
    {
        $codTable = $bbhCampoDetalhamentoFluxo->getBbhDetFluCodigo();
        $fieldSeach = ['bbhDetFluCodigo' => $codTable];
        if ($allFieldsAvailable) {
            $fieldSeach['bbhCamDetFluDisponivel'] = '1';
        }

        $token = new SecurityPassword($security['algorithm'], $security['salt'], $security['checkRegex']);
        $fields[] = [
            'name' => 'csrf_token',
            'type' => 'hidden',
            'label' => null,
            'default_value' => $token->encodePassword($codTable->getBbhDetFluCodigo(), $security['salt']),
            'description' => null,
            'required' => true
        ];

        $dynamicFields = $this->campoDetalhamentoRepository->findBy($fieldSeach);
        foreach($dynamicFields as $field) {
            $fieldDetail = $this->createFormList($field, $typeEntity = 'Flu');
            $type = $fieldDetail['type'];
            $choices = $fieldDetail['choices'];

            $detail = [
                'name' => $field->getBbhCamDetFluNome(),
                'type' => $type,
                'label' => $field->getBbhCamDetFluTitulo(),
                'default_value' => $field->getBbhCamDetFluDefault(),
                'description' => $field->getBbhCamDetFluDescricao(),
                'required' => (bool)$field->getBbhCamDetFluObrigatorio()
            ];

            !empty($choices) ? $detail['choices'] = $choices : null;
            $fields[] = $detail;
        }

        return $this->formValidatorParseRequest($formRequest, $fields);
    }

    /**
     * @todo Não curti essa implementação =/
     * @param $field
     * @param string $typeEntity
     * @return array
     */
    private function createFormList($field, $typeEntity = 'Flu')
    {
        $choices = null;
        $type = null;
        $getFieldDefaultValue = "getBbhCamDet{$typeEntity}Default";
        $getFieldType = "getBbhCamDet{$typeEntity}Tipo";

        //Atributos de uma tabela dinâmica
        switch ($field->$getFieldType()) {
            case "correio_eletronico":
            case "endereco_web":
            case "texto_simples":
                $type = 'text';
                break;
            case "hidden":
                $type = 'hidden';
                break;

            case "lista_opcoes":
                $type = 'select';
                $listChoices = [];

                $valoresLista = explode("|", $field->$getFieldDefaultValue());
                foreach($valoresLista as $item) {
                    if (empty($item)) {
                        continue;
                    }
                    array_push($listChoices, ['value' => $item, 'label' => $item]);
                }
                $choices = $listChoices;
                break;

            case "lista_dinamica":
                $type = 'select';
                $listChoices = [];
                $dynamicType = $this->campoListaDinamicaRepository->findOneByBbhCamListTitulo($field->$getFieldDefaultValue());

                if ($dynamicType) {
                    $fieldOrderBy = $dynamicType->getBbhCamListTipo() == 'A' ? 'bbhCamListMascara' : 'bbhCamListOrdem';
                    $dynamicList = $this->campoListaDinamicaRepository->findBy(
                        ['bbhCamListTitulo' => $field->$getFieldDefaultValue()],
                        [$fieldOrderBy => 'ASC']
                    );
                    $typeList = null;
                    foreach ($dynamicList as $item) {
                        if (empty($item->getBbhCamListOrdem())) {
                            $typeList = $item->getBbhCamListTipo();
                            continue;
                        }

                        $valueItem = $typeList == 'A' ? sprintf("%s - %s", $item->getBbhCamListMascara(), $item->getBbhCamListValor()) :
                            $item->getBbhCamListValor();

                        array_push($listChoices, ['value' => $valueItem, 'label' => $valueItem]);
                    }
                }
                $choices = $listChoices;
                break;

            case "texto_longo":
                $type = 'textarea';
                break;
            case "data":
                $type = 'date';
                break;

            case "time_stamp":
                $type = 'datetime';
                break;

            case "horario_editavel":
                $type = 'time';
                break;

            case "numero":
                $type = 'numeric';
                break;

            case "numero_decimal":
                $type = 'decimal';
                break;
        }

        return ['choices' => $choices, 'type' => $type];
    }

    /**
     * @param \Symfony\Component\HttpFoundation\ParameterBag $formRequest
     * @param array $listFields
     * @return array
     */
    protected function formValidatorParseRequest(ParameterBag $formRequest = null, array $listFields)
    {
        if (empty($formRequest)) {
            return $listFields;
        }

        $listErrors = [];
        foreach($listFields as $key => $field) {
            $value = $formRequest->get($field['name']);
            $listFields[$key]['value'] = sprintf('"%s"', str_replace('"', "`", $value));
            if (empty($value)) {
                $listFields[$key]['value'] = 'NULL';
            }

            if ($field['required'] && !v::notEmpty()->validate($value)) {
                $listFields[$key]['error'] = Error::REQUIRED_FIELD;

                array_push($listErrors, $listFields[$key]);
                continue;
            }

            switch ($field['type']) {
                case "select": //lista_opcoes and lista_dinamica
                    if (!ArrayHelper::inArrayRecursive($value, $field['choices'])) {
                        $listFields[$key]['error'] = Error::INVALID_SELECTED_OPTION;
                        array_push($listErrors, $listFields[$key]);
                    }
                    break;

                case "date":
                case "datetime": //time_stamp and data
                    if (!empty($value) && !v::date()->validate($value)) {
                        $listFields[$key]['error'] = Error::INVALID_DATE;
                        array_push($listErrors, $listFields[$key]);
                    }
                    break;

                case "time": // horario_editavel
                    if (!empty($value) && !preg_match("%^([0-1][0-9])|([2][0-3]):[0-5][0-9]$%", $value)) {
                        $listFields[$key]['error'] = Error::INVALID_HOUR;
                        array_push($listErrors, $listFields[$key]);
                    }
                    break;

                case "numeric": // numero
                    if (!empty($value) && !v::numeric()->validate($value)) {
                        $listFields[$key]['error'] = Error::INVALID_NUMBER;
                        array_push($listErrors, $listFields[$key]);
                    }
                    break;

                case "decimal": // numero_decimal
                    if (!empty($value) && !v::floatVal()->validate($value)) {
                        $listFields[$key]['error'] = Error::INVALID_DECIMAL;
                        array_push($listErrors, $listFields[$key]);
                    }
                    break;
            }
        }

        !empty($listErrors) ? $listFields['errors'] = $listErrors : null;
        return $listFields;
    }

    /**
     * @param $nameDefaultValue
     * @return array
     */
    public function getDynamicFieldsByDefaultValue($nameDefaultValue, $allFieldsAvailable = true, $security, $formRequest = null)
    {
        $bbhCampoDetalhamentoFluxo = $this->getTableNameDynamicDefaultValue($nameDefaultValue);
        if (empty($bbhCampoDetalhamentoFluxo)) {
            return [];
        }

        return $this->mountListDynamicForm($bbhCampoDetalhamentoFluxo, $allFieldsAvailable, $security, $formRequest);
    }

    /**
     * @param null $formRequest
     * @return array
     */
    public function getDynamicFieldsProtocolo($formRequest = null)
    {
        $fields = [];
        $dynamicFields = $this->campoDetalhamentoProtocoloRepository->findAll();
        foreach($dynamicFields as $field) {
            $fieldDetail = $this->createFormList($field, $typeEntity = 'Pro');
            $type = $fieldDetail['type'];
            $choices = $fieldDetail['choices'];

            $detail = [
                'name' => $field->getBbhCamDetProNome(),
                'type' => $type,
                'label' => $field->getBbhCamDetProTitulo(),
                'alias' => $field->getBbhCamDetProCuringa(),
//                'default_value' => $field->getBbhCamDetProDefault(),
//                'description' => $field->getBbhCamDetProDescricao(),
                'required' => (bool)$field->getBbhCamDetProObrigatorio()
            ];

            !empty($choices) ? $detail['choices'] = $choices : null;
            $fields[] = $detail;
        }

        return $this->formValidatorParseRequest($formRequest, $fields);
    }

    /**
     * @return mixed
     */
    public function getFieldsDetailWorkflow($codigoModeloFluxo)
    {
        $camposDetalhamentoRepository = $this->entityManager->getRepository('Project\Core\Entity\BbhCampoDetalhamentoFluxo');
        return $camposDetalhamentoRepository->findFieldsAbailableByModeloFluxo($codigoModeloFluxo);
    }
}
