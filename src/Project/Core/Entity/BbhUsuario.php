<?php

namespace Project\Core\Entity;

/**
 * BbhUsuario
 */
class BbhUsuario
{
    /**
     * @var integer
     */
    private $bbhUsuCodigo;

    /**
     * @var string
     */
    private $bbhUsuIdentificacao;

    /**
     * @var string
     */
    private $bbhUsuNome;

    /**
     * @var string
     */
    private $bbhUsuApelido = '584';

    /**
     * @var \DateTime
     */
    private $bbhUsuDataNascimento;

    /**
     * @var string
     */
    private $bbhUsuSexo;

    /**
     * @var \DateTime
     */
    private $bbhUsuAtribuicao;

    /**
     * @var string
     */
    private $bbhUsuRg;

    /**
     * @var string
     */
    private $bbhUsuCpf;

    /**
     * @var string
     */
    private $bbhUsuCargo;

    /**
     * @var integer
     */
    private $bbhUsuPermissaoDep;

    /**
     * @var string
     */
    private $bbhUsuTelComercial;

    /**
     * @var string
     */
    private $bbhUsuTelResidencial;

    /**
     * @var string
     */
    private $bbhUsuTelCelular;

    /**
     * @var string
     */
    private $bbhUsuTelRecados;

    /**
     * @var string
     */
    private $bbhUsuFax;

    /**
     * @var string
     */
    private $bbhUsuEmailAlternativo;

    /**
     * @var string
     */
    private $bbhUsuEndereco;

    /**
     * @var string
     */
    private $bbhUsuCidade;

    /**
     * @var string
     */
    private $bbhUsuEstado = 'SP';

    /**
     * @var string
     */
    private $bbhUsuCep;

    /**
     * @var string
     */
    private $bbhUsuPais = 'Brasil';

    /**
     * @var \DateTime
     */
    private $bbhUsuUltimoacesso = '0000-00-00 00:00:00';

    /**
     * @var integer
     */
    private $bbhUsuAtivo = '1';

    /**
     * @var string
     */
    private $bbhUsuRestringirRecebSolicitacao = '0';

    /**
     * @var string
     */
    private $bbhUsuRestringirIniProcesso = '0';

    /**
     * @var integer
     */
    private $bbhUsuNivel = '584';

    /**
     * @var \Project\Core\Entity\BbhDepartamento
     */
    private $bbhDepCodigo;

    /**
     * @var \Project\Core\Entity\BbhUsuario
     */
    private $bbhUsuChefe;


    /**
     * Get bbhUsuCodigo
     *
     * @return integer
     */
    public function getBbhUsuCodigo()
    {
        return $this->bbhUsuCodigo;
    }

    /**
     * Set bbhUsuIdentificacao
     *
     * @param string $bbhUsuIdentificacao
     *
     * @return BbhUsuario
     */
    public function setBbhUsuIdentificacao($bbhUsuIdentificacao)
    {
        $this->bbhUsuIdentificacao = $bbhUsuIdentificacao;

        return $this;
    }

    /**
     * Get bbhUsuIdentificacao
     *
     * @return string
     */
    public function getBbhUsuIdentificacao()
    {
        return $this->bbhUsuIdentificacao;
    }

    /**
     * Set bbhUsuNome
     *
     * @param string $bbhUsuNome
     *
     * @return BbhUsuario
     */
    public function setBbhUsuNome($bbhUsuNome)
    {
        $this->bbhUsuNome = $bbhUsuNome;

        return $this;
    }

    /**
     * Get bbhUsuNome
     *
     * @return string
     */
    public function getBbhUsuNome()
    {
        return $this->bbhUsuNome;
    }

    /**
     * Set bbhUsuApelido
     *
     * @param string $bbhUsuApelido
     *
     * @return BbhUsuario
     */
    public function setBbhUsuApelido($bbhUsuApelido)
    {
        $this->bbhUsuApelido = $bbhUsuApelido;

        return $this;
    }

    /**
     * Get bbhUsuApelido
     *
     * @return string
     */
    public function getBbhUsuApelido()
    {
        return $this->bbhUsuApelido;
    }

    /**
     * Set bbhUsuDataNascimento
     *
     * @param \DateTime $bbhUsuDataNascimento
     *
     * @return BbhUsuario
     */
    public function setBbhUsuDataNascimento($bbhUsuDataNascimento)
    {
        $this->bbhUsuDataNascimento = $bbhUsuDataNascimento;

        return $this;
    }

    /**
     * Get bbhUsuDataNascimento
     *
     * @return \DateTime
     */
    public function getBbhUsuDataNascimento()
    {
        return $this->bbhUsuDataNascimento;
    }

    /**
     * Set bbhUsuSexo
     *
     * @param string $bbhUsuSexo
     *
     * @return BbhUsuario
     */
    public function setBbhUsuSexo($bbhUsuSexo)
    {
        $this->bbhUsuSexo = $bbhUsuSexo;

        return $this;
    }

    /**
     * Get bbhUsuSexo
     *
     * @return string
     */
    public function getBbhUsuSexo()
    {
        return $this->bbhUsuSexo;
    }

    /**
     * Set bbhUsuAtribuicao
     *
     * @param \DateTime $bbhUsuAtribuicao
     *
     * @return BbhUsuario
     */
    public function setBbhUsuAtribuicao($bbhUsuAtribuicao)
    {
        $this->bbhUsuAtribuicao = $bbhUsuAtribuicao;

        return $this;
    }

    /**
     * Get bbhUsuAtribuicao
     *
     * @return \DateTime
     */
    public function getBbhUsuAtribuicao()
    {
        return $this->bbhUsuAtribuicao;
    }

    /**
     * Set bbhUsuRg
     *
     * @param string $bbhUsuRg
     *
     * @return BbhUsuario
     */
    public function setBbhUsuRg($bbhUsuRg)
    {
        $this->bbhUsuRg = $bbhUsuRg;

        return $this;
    }

    /**
     * Get bbhUsuRg
     *
     * @return string
     */
    public function getBbhUsuRg()
    {
        return $this->bbhUsuRg;
    }

    /**
     * Set bbhUsuCpf
     *
     * @param string $bbhUsuCpf
     *
     * @return BbhUsuario
     */
    public function setBbhUsuCpf($bbhUsuCpf)
    {
        $this->bbhUsuCpf = $bbhUsuCpf;

        return $this;
    }

    /**
     * Get bbhUsuCpf
     *
     * @return string
     */
    public function getBbhUsuCpf()
    {
        return $this->bbhUsuCpf;
    }

    /**
     * Set bbhUsuCargo
     *
     * @param string $bbhUsuCargo
     *
     * @return BbhUsuario
     */
    public function setBbhUsuCargo($bbhUsuCargo)
    {
        $this->bbhUsuCargo = $bbhUsuCargo;

        return $this;
    }

    /**
     * Get bbhUsuCargo
     *
     * @return string
     */
    public function getBbhUsuCargo()
    {
        return $this->bbhUsuCargo;
    }

    /**
     * Set bbhUsuPermissaoDep
     *
     * @param integer $bbhUsuPermissaoDep
     *
     * @return BbhUsuario
     */
    public function setBbhUsuPermissaoDep($bbhUsuPermissaoDep)
    {
        $this->bbhUsuPermissaoDep = $bbhUsuPermissaoDep;

        return $this;
    }

    /**
     * Get bbhUsuPermissaoDep
     *
     * @return integer
     */
    public function getBbhUsuPermissaoDep()
    {
        return $this->bbhUsuPermissaoDep;
    }

    /**
     * Set bbhUsuTelComercial
     *
     * @param string $bbhUsuTelComercial
     *
     * @return BbhUsuario
     */
    public function setBbhUsuTelComercial($bbhUsuTelComercial)
    {
        $this->bbhUsuTelComercial = $bbhUsuTelComercial;

        return $this;
    }

    /**
     * Get bbhUsuTelComercial
     *
     * @return string
     */
    public function getBbhUsuTelComercial()
    {
        return $this->bbhUsuTelComercial;
    }

    /**
     * Set bbhUsuTelResidencial
     *
     * @param string $bbhUsuTelResidencial
     *
     * @return BbhUsuario
     */
    public function setBbhUsuTelResidencial($bbhUsuTelResidencial)
    {
        $this->bbhUsuTelResidencial = $bbhUsuTelResidencial;

        return $this;
    }

    /**
     * Get bbhUsuTelResidencial
     *
     * @return string
     */
    public function getBbhUsuTelResidencial()
    {
        return $this->bbhUsuTelResidencial;
    }

    /**
     * Set bbhUsuTelCelular
     *
     * @param string $bbhUsuTelCelular
     *
     * @return BbhUsuario
     */
    public function setBbhUsuTelCelular($bbhUsuTelCelular)
    {
        $this->bbhUsuTelCelular = $bbhUsuTelCelular;

        return $this;
    }

    /**
     * Get bbhUsuTelCelular
     *
     * @return string
     */
    public function getBbhUsuTelCelular()
    {
        return $this->bbhUsuTelCelular;
    }

    /**
     * Set bbhUsuTelRecados
     *
     * @param string $bbhUsuTelRecados
     *
     * @return BbhUsuario
     */
    public function setBbhUsuTelRecados($bbhUsuTelRecados)
    {
        $this->bbhUsuTelRecados = $bbhUsuTelRecados;

        return $this;
    }

    /**
     * Get bbhUsuTelRecados
     *
     * @return string
     */
    public function getBbhUsuTelRecados()
    {
        return $this->bbhUsuTelRecados;
    }

    /**
     * Set bbhUsuFax
     *
     * @param string $bbhUsuFax
     *
     * @return BbhUsuario
     */
    public function setBbhUsuFax($bbhUsuFax)
    {
        $this->bbhUsuFax = $bbhUsuFax;

        return $this;
    }

    /**
     * Get bbhUsuFax
     *
     * @return string
     */
    public function getBbhUsuFax()
    {
        return $this->bbhUsuFax;
    }

    /**
     * Set bbhUsuEmailAlternativo
     *
     * @param string $bbhUsuEmailAlternativo
     *
     * @return BbhUsuario
     */
    public function setBbhUsuEmailAlternativo($bbhUsuEmailAlternativo)
    {
        $this->bbhUsuEmailAlternativo = $bbhUsuEmailAlternativo;

        return $this;
    }

    /**
     * Get bbhUsuEmailAlternativo
     *
     * @return string
     */
    public function getBbhUsuEmailAlternativo()
    {
        return $this->bbhUsuEmailAlternativo;
    }

    /**
     * Set bbhUsuEndereco
     *
     * @param string $bbhUsuEndereco
     *
     * @return BbhUsuario
     */
    public function setBbhUsuEndereco($bbhUsuEndereco)
    {
        $this->bbhUsuEndereco = $bbhUsuEndereco;

        return $this;
    }

    /**
     * Get bbhUsuEndereco
     *
     * @return string
     */
    public function getBbhUsuEndereco()
    {
        return $this->bbhUsuEndereco;
    }

    /**
     * Set bbhUsuCidade
     *
     * @param string $bbhUsuCidade
     *
     * @return BbhUsuario
     */
    public function setBbhUsuCidade($bbhUsuCidade)
    {
        $this->bbhUsuCidade = $bbhUsuCidade;

        return $this;
    }

    /**
     * Get bbhUsuCidade
     *
     * @return string
     */
    public function getBbhUsuCidade()
    {
        return $this->bbhUsuCidade;
    }

    /**
     * Set bbhUsuEstado
     *
     * @param string $bbhUsuEstado
     *
     * @return BbhUsuario
     */
    public function setBbhUsuEstado($bbhUsuEstado)
    {
        $this->bbhUsuEstado = $bbhUsuEstado;

        return $this;
    }

    /**
     * Get bbhUsuEstado
     *
     * @return string
     */
    public function getBbhUsuEstado()
    {
        return $this->bbhUsuEstado;
    }

    /**
     * Set bbhUsuCep
     *
     * @param string $bbhUsuCep
     *
     * @return BbhUsuario
     */
    public function setBbhUsuCep($bbhUsuCep)
    {
        $this->bbhUsuCep = $bbhUsuCep;

        return $this;
    }

    /**
     * Get bbhUsuCep
     *
     * @return string
     */
    public function getBbhUsuCep()
    {
        return $this->bbhUsuCep;
    }

    /**
     * Set bbhUsuPais
     *
     * @param string $bbhUsuPais
     *
     * @return BbhUsuario
     */
    public function setBbhUsuPais($bbhUsuPais)
    {
        $this->bbhUsuPais = $bbhUsuPais;

        return $this;
    }

    /**
     * Get bbhUsuPais
     *
     * @return string
     */
    public function getBbhUsuPais()
    {
        return $this->bbhUsuPais;
    }

    /**
     * Set bbhUsuUltimoacesso
     *
     * @param \DateTime $bbhUsuUltimoacesso
     *
     * @return BbhUsuario
     */
    public function setBbhUsuUltimoacesso($bbhUsuUltimoacesso)
    {
        $this->bbhUsuUltimoacesso = $bbhUsuUltimoacesso;

        return $this;
    }

    /**
     * Get bbhUsuUltimoacesso
     *
     * @return \DateTime
     */
    public function getBbhUsuUltimoacesso()
    {
        return $this->bbhUsuUltimoacesso;
    }

    /**
     * Set bbhUsuAtivo
     *
     * @param integer $bbhUsuAtivo
     *
     * @return BbhUsuario
     */
    public function setBbhUsuAtivo($bbhUsuAtivo)
    {
        $this->bbhUsuAtivo = $bbhUsuAtivo;

        return $this;
    }

    /**
     * Get bbhUsuAtivo
     *
     * @return integer
     */
    public function getBbhUsuAtivo()
    {
        return $this->bbhUsuAtivo;
    }

    /**
     * Set bbhUsuRestringirRecebSolicitacao
     *
     * @param string $bbhUsuRestringirRecebSolicitacao
     *
     * @return BbhUsuario
     */
    public function setBbhUsuRestringirRecebSolicitacao($bbhUsuRestringirRecebSolicitacao)
    {
        $this->bbhUsuRestringirRecebSolicitacao = $bbhUsuRestringirRecebSolicitacao;

        return $this;
    }

    /**
     * Get bbhUsuRestringirRecebSolicitacao
     *
     * @return string
     */
    public function getBbhUsuRestringirRecebSolicitacao()
    {
        return $this->bbhUsuRestringirRecebSolicitacao;
    }

    /**
     * Set bbhUsuRestringirIniProcesso
     *
     * @param string $bbhUsuRestringirIniProcesso
     *
     * @return BbhUsuario
     */
    public function setBbhUsuRestringirIniProcesso($bbhUsuRestringirIniProcesso)
    {
        $this->bbhUsuRestringirIniProcesso = $bbhUsuRestringirIniProcesso;

        return $this;
    }

    /**
     * Get bbhUsuRestringirIniProcesso
     *
     * @return string
     */
    public function getBbhUsuRestringirIniProcesso()
    {
        return $this->bbhUsuRestringirIniProcesso;
    }

    /**
     * Set bbhUsuNivel
     *
     * @param integer $bbhUsuNivel
     *
     * @return BbhUsuario
     */
    public function setBbhUsuNivel($bbhUsuNivel)
    {
        $this->bbhUsuNivel = $bbhUsuNivel;

        return $this;
    }

    /**
     * Get bbhUsuNivel
     *
     * @return integer
     */
    public function getBbhUsuNivel()
    {
        return $this->bbhUsuNivel;
    }

    /**
     * Set bbhDepCodigo
     *
     * @param \Project\Core\Entity\BbhDepartamento $bbhDepCodigo
     *
     * @return BbhUsuario
     */
    public function setBbhDepCodigo(\Project\Core\Entity\BbhDepartamento $bbhDepCodigo = null)
    {
        $this->bbhDepCodigo = $bbhDepCodigo;

        return $this;
    }

    /**
     * Get bbhDepCodigo
     *
     * @return \Project\Core\Entity\BbhDepartamento
     */
    public function getBbhDepCodigo()
    {
        return $this->bbhDepCodigo;
    }

    /**
     * Set bbhUsuChefe
     *
     * @param \Project\Core\Entity\BbhUsuario $bbhUsuChefe
     *
     * @return BbhUsuario
     */
    public function setBbhUsuChefe(\Project\Core\Entity\BbhUsuario $bbhUsuChefe = null)
    {
        $this->bbhUsuChefe = $bbhUsuChefe;

        return $this;
    }

    /**
     * Get bbhUsuChefe
     *
     * @return \Project\Core\Entity\BbhUsuario
     */
    public function getBbhUsuChefe()
    {
        return $this->bbhUsuChefe;
    }
}

