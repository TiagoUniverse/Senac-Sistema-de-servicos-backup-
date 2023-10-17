
/**
 * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
 * ║                                               Sistema de Serviços                                                 ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ NOTA: Todas as informações contidas neste documento são propriedade do SENAC PERNAMBUCO e seus fornecedores,│  ║
 * ║  │ caso existam. Os conceitos intelectuais e técnicos contidos são propriedade do SENAC PERNAMBUCO e seus      │  ║
 * ║  │ fornecedores e podem estar cobertos pelas patentes nacionais, e estão protegidas por segredo comercial ou   │  ║
 * ║  │ lei de direitos autorais. Divulgação desta informação ou reprodução deste material é estritamente proibido, │  ║
 * ║  │ a menos que seja obtida permissão prévia por escrito do SENAC PERNAMBUCO.                                   │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ @description: This system is responsible for registering new employees and creating your SENAC				│  ║
 * ║  |	institutional email                                                                                         │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date 12/11/22                                                                                              │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 * ║                                                     UPGRADES                                                      ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 1. @date: 19/01/23                                                                                          │  ║
 * ║  │    @description Adding time to the days of the week of the 'Colaborador'                                    │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║																										   ║
 * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
 */

    /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║1-                                                  Usuário	                                                   ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description                                                                                                  │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [Usuario] (
        [id]							INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
		[nome]							VARCHAR(200)      NOT NULL DEFAULT '',
		[nomeSobrenome]					VARCHAR(200)      NOT NULL DEFAULT '',
		[email]							VARCHAR(200)      NOT NULL DEFAULT '',
		[senha]							VARCHAR(200)	  NOT NULL DEFAULT '',
		[cpf]							VARCHAR(200)	  NOT NULL DEFAULT '',
		[dataNascimento]				DATE			  NOT NULL DEFAULT '',
		[telefone]						VARCHAR(200)      NOT NULL DEFAULT '',
		[trocarSenha]					TINYINT			  NOT NULL DEFAULT '0',
		[status]						VARCHAR(200)      NOT NULL DEFAULT 'ATIVO',
        [created]						DATETIME          NOT NULL DEFAULT GETDATE(),
        [updated]						DATETIME              NULL,

		[idNivelDeAcesso]				INT				  NOT NULL,
		[idUnidade]						INT				  NOT NULL,
		
		FOREIGN KEY([idNivelDeAcesso])		REFERENCES NivelDeAcesso(id),
		FOREIGN KEY([idUnidade])			REFERENCES Unidade(id),

    );

	
    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ INSERT                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
Insert into [Usuario]
	(nome, nomeSobrenome, email, senha , cpf, dataNascimento, telefone) values
	('' , '' , '' , HASHBYTES('sha1', '') , '' , '' , '')

/**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║ 2-                                        Unidade                                                             ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description: "Unidade" (unity) store all the unities from Senac. For example: GTI, SENAC Collegue.           │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [Unidade](
        [id]				INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
		[nome]				VARCHAR(200)      NOT NULL DEFAULT '',
        [status]			VARCHAR(200)      NOT NULL DEFAULT 'ATIVO',
        [created]			DATETIME          NOT NULL DEFAULT GETDATE(),
        [updated]			DATETIME              NULL
    );

	
    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ INSERT                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    INSERT INTO [Unidade]
        ( [nome] , [descricao]) 
    VALUES 
        ('' , '');
		

/**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║ 3-                                          NivelDeAcesso		                                               ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description: It stores all the access level classification to the system                                     │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [NivelDeAcesso](
        [id]				INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
		[nome]				VARCHAR(1000)     NOT NULL DEFAULT '',
        [status]			VARCHAR(200)      NOT NULL DEFAULT 'ATIVO',
        [created]			DATETIME          NOT NULL DEFAULT GETDATE(),
        [updated]			DATETIME              NULL
    );


    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ INSERT                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    INSERT INTO [NivelDeAcesso]
        ([nome]) 
    VALUES 
        (''); 


	/**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ SELECT                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
		Select
	/* NIVELDEACESSO    */
	n.id as idNivelDeAcesso, n.nome as nomeNivelDeAcesso, n.descricao as descricaoNivelDeAcesso, n.status as statusNivelDeAcesso, 
	n.created as dataCriacaoNivelDeAcesso, n.updated as DataAtualizacaoNivelDeAcesso, n.description as descricaoNivelDeAcesso

from
	NivelDeAcesso as n


/**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║ 4-                                          Servicos			                                               ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description: Table of registers of services that the RH can use							                   │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [Servicos](
        [id]				INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
		[nome]				VARCHAR(MAX)	  NOT NULL DEFAULT '',
		[descricao]			VARCHAR(MAX)	  NOT NULL DEFAULT '',
        [status]			VARCHAR(200)      NOT NULL DEFAULT 'ATIVO',
        [created]			DATETIME          NOT NULL DEFAULT GETDATE(),
        [updated]			DATETIME              NULL,

		idUsuario			INT NOT NULL,

		FOREIGN KEY (idUsuario)			REFERENCES	Usuario		(id)
    );

  /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║5-                                                  Colaborador                                                ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description                                                                                                  │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [Colaborador] (
        [id]							INT IDENTITY(1,1)		NOT NULL PRIMARY KEY,
		[id_criptografado]				VARCHAR		(300)			NULL DEFAULT '' ,
		[nome]							VARCHAR		(300)		NOT NULL DEFAULT '',
		[cpf]							VARCHAR		(300)		NOT NULL DEFAULT '',
		[email_pessoal]					VARCHAR		(300)		NOT NULL DEFAULT '',
		[telefone]						VARCHAR		(300)		NOT NULL DEFAULT '',
		[status]						VARCHAR		(200)		NOT NULL DEFAULT 'ATIVO',
		[created]						DATETIME				NOT NULL DEFAULT '',
		[updated]						DATETIME				    NULL DEFAULT '',

		[idServicos]						INT				  NOT NULL,
		FOREIGN KEY([idServicos])			REFERENCES Servicos(id)

    );

	
    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ INSERT                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */

/**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║ 6-                                          TimeLine			                                               ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description: The record and timeline from all the operations with the new workers                            │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [Timeline](
        [id]				INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
		[nome]				VARCHAR(1000)     NOT NULL DEFAULT '',
		[id_funcionario]	INT				      NULL,
        [created]			DATETIME          NOT NULL DEFAULT GETDATE(),

		
		[idColaborador]		INT				  NOT NULL,
		[idStatusTimeline]	INT				  NOT NULL,

		FOREIGN KEY([idColaborador])			REFERENCES Colaborador(id),
		FOREIGN KEY([idStatusTimeline])			REFERENCES StatusTimeline(id)

    );


    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ INSERT                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    INSERT INTO [Timeline]
        ([nome], [id_funcionario] , [idColaborador] , [idStatusTimeline] ) 
    VALUES 
        ('' , '' , '' , ''); 


	/**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ SELECT                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */

/**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║ 7-                                          StatusTimeline                                                    ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description: Status from the operations and the timeline			                                           │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [StatusTimeline](
        [id]				INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
		[descricao]			VARCHAR(1000)     NOT NULL DEFAULT '',
        [created]			DATETIME          NOT NULL DEFAULT GETDATE(),
        [updated]			DATETIME              NULL,

    );

 /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ INSERT                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    INSERT INTO [StatusTimeline]
        ([descricao]) 
    VALUES 
        ('Conclusão da operação'); 


	/**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ SELECT                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */



/**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║ 8-                                             ENVIO_EMAILS                                                   ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description: Envio de e-mails e controle para um respectivo colaborador				                       │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [Envio_emails] (
        [id]					INT IDENTITY(1,1)  NOT NULL PRIMARY KEY,
		[de]					VARCHAR(300)	   NOT NULL DEFAULT '',
		[para]					VARCHAR(300)	   NOT NULL DEFAULT '',
		[cc]					VARCHAR(300)		   NULL DEFAULT '',
		[assunto]				VARCHAR(300)	   NOT NULL DEFAULT '',
		[conteudo]				text			   NOT NULL DEFAULT '',
		[data_envio]			DATETIME		   	   NULL DEFAULT '',
        [status_enviado]    	INT			      NOT NULL DEFAULT '0',
		[data_cadastroEmail]			DATETIME		  NOT NULL DEFAULT GETDATE(),

		[idColaborador]		INT				  NOT NULL,

		FOREIGN KEY([idColaborador])			REFERENCES Colaborador(id)

    );


/**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║ 9-                                             CodigoEtica_Colaborador                                        ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description: Tabela de solicitação do código de ética de um colaborador				                       │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [CodigoEtica_Colaborador] (
        [id]					INT IDENTITY(1,1)  NOT NULL PRIMARY KEY,
		[id_criptografia]		VARCHAR(300)		   NULL DEFAULT '',
		[nome]					VARCHAR(300)	   NOT NULL DEFAULT '',
		[cpf]					VARCHAR(300)	   NOT NULL DEFAULT '',
		[email]					VARCHAR(300)	   NOT NULL DEFAULT '',
		[telefone]				VARCHAR(300)	   NOT NULL DEFAULT '',
		[dataAceite]			DATETIME		       NULL DEFAULT '',
		[nome_arquivo]			VARCHAR(max)	   NOT NULL DEFAULT '',
		[status]				INT				   NOT NULL DEFAULT '1',
		[created]				DATETIME		   NOT NULL DEFAULT GETDATE(),
		[updated]				DATETIME			   NULL DEFAULT '',
		[idUsuario]				INT				NOT NULL,

		FOREIGN KEY([idUsuario]) REFERENCES Usuario(id)

    );

	
    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ INSERT                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
	 Insert INTO CodigoEtica_Colaborador (nome, cpf, email) Values
	 ('', '', '');


/**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║ 10-                                             Timeline_CodigoEtica	                                       ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description: Timeline do código de ética												                       │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [Timeline_CodigoEtica] (
        [id]						INT IDENTITY(1,1)  NOT NULL PRIMARY KEY,
		[descricao]					VARCHAR(300)	   NOT NULL DEFAULT '',
		[created]					DATETIME		   NOT NULL DEFAULT GETDATE(),
		[idUsuario]					INT				NOT NULL,
		[idCodigoEtica_Colaborador]	INT				NOT NULL,
		[idStatusTimeline_CodigoEtica] INT			NOT NULL,

		FOREIGN KEY([idUsuario]) REFERENCES Usuario(id),
		FOREIGN KEY([idCodigoEtica_Colaborador]) REFERENCES CodigoEtica_Colaborador([id]),
		FOREIGN KEY ([idStatusTimeline_CodigoEtica]) REFERENCES StatusTimeline

    );

	
    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ INSERT                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
	 Insert INTO [Timeline_CodigoEtica] (descricao, idUsuario, idCodigoEtica_Colaborador, idStatusTimeline_CodigoEtica) Values
	 ('', '' , '');


/**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║ 11-                                             StatusTimeline_CodigoEtica	                                   ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description: Status da timeline do código de ética									                       │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [StatusTimeline_CodigoEtica] (
        [id]						INT IDENTITY(1,1)  NOT NULL PRIMARY KEY,
		[descricao]					VARCHAR(300)	   NOT NULL DEFAULT '',
		[created]					DATETIME		   NOT NULL DEFAULT GETDATE(),
		[updated]					DATETIME				NULL

    );

	
    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ INSERT                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
	 Insert INTO [StatusTimeline_CodigoEtica] (descricao) Values
	 ('');


/**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║ 12-                                             Envio_Emails_CodigoEtica	                                   ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description: Tabela para registrar os e-mails disparados a respeito do código de ética                       │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [Envio_Emails_CodigoEtica] (
        [id]					INT IDENTITY(1,1)  NOT NULL PRIMARY KEY,
		[de]					VARCHAR(300)	   NOT NULL DEFAULT '',
		[para]					VARCHAR(300)	   NOT NULL DEFAULT '',
		[cc]					VARCHAR(300)		   NULL DEFAULT '',
		[assunto]				VARCHAR(300)	   NOT NULL DEFAULT '',
		[conteudo]				text			   NOT NULL DEFAULT '',
		[data_envio]			DATETIME		   	   NULL DEFAULT '',
        [status_enviado]    	INT			      NOT NULL DEFAULT '0',
		[data_cadastroEmail]	DATETIME		  NOT NULL DEFAULT GETDATE(),

		[idCodigoEtica_Colaborador]	INT				NOT NULL,

		FOREIGN KEY([idCodigoEtica_Colaborador]) REFERENCES CodigoEtica_Colaborador([id])

    );

	
    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ INSERT                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
	 Insert INTO [StatusTimeline_CodigoEtica] (descricao) Values
	 ('');

 /**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║                                                  TABELA MODELO                                                ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description                                                                                                  │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [NOME](
        [id]           INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
        [nivel]        VARCHAR(200)      NOT NULL DEFAULT '',
        [status]       INT               NOT NULL DEFAULT '1',
        [created]      DATETIME          NOT NULL DEFAULT GETDATE(),
        [updated]      DATETIME              NULL
    );

	
    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ INSERT                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    INSERT INTO [NivelDificuldade]
        ([nivel]) 
    VALUES 
        (''); 
		