/**
 * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
 * ║                                                   NOME DO SISTEMA                                                 ║
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
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 2. @date: 13/02/23                                                                                          │  ║
 * ║  │    @description: Employee time changed									                                    │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 3. @date: 05/10/23                                                                                          │  ║
 * ║  │    @description: Addind section about the 'Código de ética'									                │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║																												   ║
 * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
 */

/**	=================================================================================================================== **/
/* TOTVS */
/*
select *,month( cast(DATAADMISSAO as date))  from TOTVS 
        where len(DATAADMISSAO) = 10 
        and year( cast(DATAADMISSAO as date)) = year(getdate()) 
        and month( cast(DATAADMISSAO as date)) >= month(getdate() ) - 1
		*/


/**
select 
	  distinct *,month( cast(DATAADMISSAO as date)) 
from 
	TOTVS
Where
	year(cast(DATAADMISSAO as date)) = (2023)
	and month( cast(DATAADMISSAO as date)) >= (3)
order by 
	(DATAADMISSAO) desc


**/

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
		[status]						INT               NOT NULL DEFAULT '1',
        [created]						DATETIME          NOT NULL DEFAULT GETDATE(),
        [updated]						DATETIME              NULL,
		[description]					VARCHAR(1000)     NOT NULL DEFAULT '',

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
		[descricao]			VARCHAR(1000)	  NOT NULL DEFAULT '',
        [status]			INT               NOT NULL DEFAULT '1',
        [created]			DATETIME          NOT NULL DEFAULT GETDATE(),
        [updated]			DATETIME              NULL,
		[description]		VARCHAR(1000)     NOT NULL DEFAULT '',
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
		[descricao]			VARCHAR(1000)	  NOT NULL DEFAULT '',
        [status]			INT               NOT NULL DEFAULT '1',
        [created]			DATETIME          NOT NULL DEFAULT GETDATE(),
        [updated]			DATETIME              NULL,
		[description]		VARCHAR(1000)     NOT NULL DEFAULT '',
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
     * ║ 4-                                          Criacao_email		                                               ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @description: Its stores when an institucional e-mail was created by an 'Support GTI' worker                  │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    CREATE TABLE [Criacao_email](
        [id]				INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
		[nome_criador]		VARCHAR(300)      NOT NULL DEFAULT '',
		[nome_Colaborador]	VARCHAR(300)	  NOT NULL DEFAULT '',
        [status]			INT               NOT NULL DEFAULT '1',
        [created]			DATETIME          NOT NULL DEFAULT GETDATE(),
        [updated]			DATETIME              NULL,
		[description]		VARCHAR(1000)     NOT NULL DEFAULT '',
		idUsuario			INT				  NOT NULL,
		idColaborador		INT				  NOT NULL

		FOREIGN KEY (idUsuario)			REFERENCES	Usuario		(id),
		FOREIGN KEY (idColaborador)		REFERENCES	Colaborador	(id)
    );


    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ INSERT                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    INSERT INTO [Criacao_email]
        ([nome_criador], idUsuario) 
    VALUES 
        ('' , ''); 


	/**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ SELECT                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
		Select
			*
		from
			Criacao_email
		Where
			status = 1;


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
		[nome]							VARCHAR		(200)		NOT NULL DEFAULT '',
		[cpf]							VARCHAR		(300)		NOT NULL DEFAULT '',
		[dataNascimento]				DATE					NOT NULL,
		[email_pessoal]					VARCHAR		(200)		NOT NULL DEFAULT '',
		[email_institucional]			VARCHAR		(200)		    NULL DEFAULT '',
		[motivo_solicitacao]			VARCHAR		(500)		    NULL DEFAULT '',
		[telefone]						VARCHAR		(200)		NOT NULL DEFAULT '',
		[chapa]							VARCHAR		(200)		NOT NULL DEFAULT '',
		[funcao]						VARCHAR		(200)		NOT NULL DEFAULT '',
		[gerencia]						VARCHAR		(200)		NOT NULL DEFAULT '',
		[setor]							VARCHAR		(200)		NOT NULL DEFAULT '',
		[ramal]							VARCHAR		(200)		    NULL DEFAULT '',
		[rua]							VARCHAR		(200)		NOT NULL DEFAULT '',
		[numero_endereco]				VARCHAR		(200)		NOT NULL DEFAULT '',
		[bairro]						VARCHAR		(200)		NOT NULL DEFAULT '',
		[HorarioTrabalho]				VARCHAR	    (300)		NOT NULL DEFAULT '',
		[observacao]					VARCHAR		(300)		NOT NULL DEFAULT '',
		[status]						INT						NOT NULL DEFAULT '',
		[created]						DATETIME				NOT NULL DEFAULT '',
		[updated]						DATETIME				    NULL DEFAULT '',
		[description]					VARCHAR    (1000)		NOT NULL DEFAULT '',


		[idUnidade]						INT				  NOT NULL,
		FOREIGN KEY([idUnidade])			REFERENCES Unidade(id),

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
		