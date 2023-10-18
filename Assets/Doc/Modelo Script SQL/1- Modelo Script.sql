
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
 * ║  │ @description: A system to create services and manage them										            │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date 17/10/23                                                                                              │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 * ║                                                     UPGRADES                                                      ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 1. @date:			                                                                                        │  ║
 * ║  │    @description															                                    │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
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
		[administrador]					TINYINT			      NULL DEFAULT '',
		[email]							VARCHAR(200)      NOT NULL DEFAULT '',
		[senha]							VARCHAR(200)	  NOT NULL DEFAULT '',
		[cpf]							VARCHAR(200)	  NOT NULL DEFAULT '',
		[dataNascimento]				DATE			  NOT NULL DEFAULT '',
		[telefone]						VARCHAR(200)      NOT NULL DEFAULT '',
		[trocarSenha]					TINYINT			  NOT NULL DEFAULT '0',
		[status]						VARCHAR(200)      NOT NULL DEFAULT 'ATIVO',
        [created]						DATETIME          NOT NULL DEFAULT GETDATE(),
        [updated]						DATETIME              NULL,

	/*	[idNivelDeAcesso]				INT				  NOT NULL, */
		[idUnidade]						INT				  NOT NULL,
		
	/*	FOREIGN KEY([idNivelDeAcesso])		REFERENCES NivelDeAcesso(id), */
		FOREIGN KEY([idUnidade])			REFERENCES Unidade(id)

    );

	
    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ INSERT                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
Insert into [Usuario]
	(nome, nomeSobrenome, email, senha , cpf, dataNascimento, telefone) values
	('' , '' , '' , HASHBYTES('sha1', '') , '' , '' , '')

	Insert into [Usuario]
	(nome, nomeSobrenome, email, senha , cpf, dataNascimento, telefone, idUnidade) values
	('Tiago' , 'Tiago César' , 'tiagocesar68@gmail.com' , HASHBYTES('sha1', 'senha') , '71240924429' , '05/10/2001' , '40028922', 1)

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

	 /*
    CREATE TABLE [NivelDeAcesso](
        [id]				INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
		[nome]				VARCHAR(1000)     NOT NULL DEFAULT '',
        [status]			VARCHAR(200)      NOT NULL DEFAULT 'ATIVO',
        [created]			DATETIME          NOT NULL DEFAULT GETDATE(),
        [updated]			DATETIME              NULL
    );

	*/

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
     * ║ 3-                                          Servicos			                                               ║
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
     * ║4-                                                  Colaborador                                                ║
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

/**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║ 5-                                          TimeLine			                                               ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description: Timeline of an Colaborador											                           │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [Timeline](
        [id]				INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
		[descricao]			VARCHAR(1000)     NOT NULL DEFAULT '',
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
        ([descricao], [idColaborador] , [idStatusTimeline] ) 
    VALUES 
        ('' , '' , ''); 

/**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║ 6-                                          StatusTimeline                                                    ║
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
        [updated]			DATETIME              NULL
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


/**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║ 7-                                             Status_TemplateEmail                                           ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description: Status de um template de email que vai ser disparado						                       │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [Status_TemplateEmail] (
        [id]					INT IDENTITY(1,1)  NOT NULL PRIMARY KEY,
		[nome]					VARCHAR(300)	   NOT NULL DEFAULT '',
		[created]			DATETIME          NOT NULL DEFAULT GETDATE(),
        [updated]			DATETIME              NULL

    );


/**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║ 8-                                             Email_Destinatario	                                           ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description: Status de um template de email que vai ser disparado						                       │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [Email_Destinatario] (
        [id]					INT IDENTITY(1,1)  NOT NULL PRIMARY KEY,
		[email]					VARCHAR(300)	   NOT NULL DEFAULT '',
		[status]				VARCHAR(300)	   NOT NULL DEFAULT 'ATIVO',
		[created]			DATETIME          NOT NULL DEFAULT GETDATE(),
        [updated]			DATETIME              NULL,

		[idTemplate_Email]	INT NOT NULL,

		FOREIGN KEY ([idTemplate_Email]) REFERENCES Template_Email([id])

    );


/**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║ 9-                                             Template_Email		                                           ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description: Template for an email													                       │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [Template_Email] (
        [id]					INT IDENTITY(1,1)  NOT NULL PRIMARY KEY,
		[descricao]				VARCHAR(MAX)	   NOT NULL DEFAULT '',
		[status]				VARCHAR(300)	   NOT NULL DEFAULT 'ATIVO',
		[created]				DATETIME          NOT NULL DEFAULT GETDATE(),
        [updated]				DATETIME              NULL,

		[idStatus_TemplateEmail]	INT NOT NULL,
		[idServicos]				INT NOT NULL,

		FOREIGN KEY ([idStatus_TemplateEmail]) REFERENCES Status_TemplateEmail([id]),
		FOREIGN KEY ([idServicos]) REFERENCES Servicos([id])

    );


/**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║ 10-                                            ENVIO_EMAILS                                                   ║
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

		[idTemplate_Email]		INT				  NOT NULL,

		FOREIGN KEY([idTemplate_Email])			REFERENCES Template_Email(id)

    );


/**	=================================================================================================================== **/

 /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║ 11-                                             Anexo						                                   ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description: Tabela para registrar os e-mails disparados a respeito do código de ética                       │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE Anexo(
        [id]			INT IDENTITY(1,1)		NOT NULL PRIMARY KEY,
		[nomeFantasia]	VARCHAR(1000)			NOT NULL DEFAULT '',
		[nome]			VARCHAR(1000)			NOT NULL DEFAULT '',
		[tipoArquivo]	VARCHAR(300)			NOT NULL DEFAULT '',
		[diretorio]		VARCHAR(500)			NOT NULL DEFAULT '',
        [status]		VARCHAR(300)			NOT NULL DEFAULT 'ATIVO',
        [created]		DATETIME				NOT NULL DEFAULT GETDATE(),
        [updated]		DATETIME					NULL,
		[idTemplate_Email]		INT				  NOT NULL,

		FOREIGN KEY([idTemplate_Email])			REFERENCES Template_Email(id)
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
		