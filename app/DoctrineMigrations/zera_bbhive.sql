update bbh_protocolos set bbh_flu_codigo = null;
update bbh_protocolos set bbh_flu_pai = null;
delete from bbh_paragrafo;
delete from bbh_relatorio;
delete from bbh_atividade;
delete from bbh_arquivo;
delete from bbh_fluxo;
delete from bbh_fluxo_alternativa;
delete from bbh_fluxo_relacionado;
delete from bbh_permissao_fluxo;
delete from bbh_campo_detalhamento_atividade;
delete from bbh_campo_detalhamento_fluxo;
delete from bbh_detalhamento_fluxo;
delete from bbh_dependencia;
delete from bbh_modelo_atividade;
delete from bbh_modelo_paragrafo;
delete from bbh_modelo_fluxo;
delete from bbh_tipo_fluxo;