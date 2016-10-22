CREATE DATABASE IF NOT EXISTS SCA;

USE SCA;

CREATE TABLE IF NOT EXISTS Endereco(
	IdEndereco int unsigned AUTO_INCREMENT NOT NULL,
	Rua varchar(256) NOT NULL,
	Numero int unsigned NOT NULL,
	Bairro varchar(64) NOT NULL,
	Cidade varchar(64) NOT NULL,
	Complemento varchar(64),
	CEP varchar(9) NOT NULL,
	Estado varchar(64) NOT NULL,
	PRIMARY KEY (IdEndereco)
);

CREATE TABLE IF NOT EXISTS Curso (
	IdCurso int unsigned AUTO_INCREMENT NOT NULL,
	Nome varchar(256) NOT NULL,
	Cpf_Coordenador varchar(14) NOT NULL,
	Cpf_Vice_coordenador varchar(14) NOT NULL,
	IdFaculdade int unsigned NOT NULL,
	CreditosParaConclusao int (5) unsigned NOT NULL,
	PRIMARY KEY (IdCurso)
);

#Talvez criar uma nova tabela chamada pessoa e
# deixar apenas o cpf no Coordenador e Vice_coordenador
####
CREATE TABLE IF NOT EXISTS Pessoa(
	CPF varchar(14) NOT NULL,
	Nome varchar(256) NOT NULL,
	DataNasc date,
	IdEndereco INT unsigned NOT NULL,
	PRIMARY KEY (CPF)	
);
####
CREATE TABLE IF NOT EXISTS Professor(###
	Cpf_Docente varchar(14) NOT NULL,
	PRIMARY KEY (Cpf_Docente)	
);

CREATE TABLE IF NOT EXISTS ProfessorExterno(###
	Cpf_Docente varchar(14) NOT NULL,
	PRIMARY KEY (Cpf_Docente)	
);

CREATE TABLE IF NOT EXISTS Coordenador(###
	Cpf_Docente varchar(14) NOT NULL,
	PRIMARY KEY (Cpf_Docente)	
);

CREATE TABLE IF NOT EXISTS Vice_coordenador(###
	Cpf_Docente varchar(14) NOT NULL,
	PRIMARY KEY (Cpf_Docente)
);

CREATE TABLE IF NOT EXISTS Faculdade(
	IdFaculdade int unsigned AUTO_INCREMENT NOT NULL,
	Nome varchar(256) NOT NULL,
	IdEndereco int unsigned NOT NULL,
	PRIMARY KEY (IdFaculdade)
);

CREATE TABLE IF NOT EXISTS Laboratorio(
	Nome varchar(256) NOT NULL,
	Sigla varchar(64) NOT NULL,
	IdFaculdade int unsigned NOT NULL,
	PRIMARY KEY (Sigla)
);

CREATE TABLE IF NOT EXISTS Projeto(
	IdProjeto int unsigned AUTO_INCREMENT NOT NULL,
	Nome varchar(256) NOT NULL,
	Area varchar(256) NOT NULL,
	DataInicio date,
	PrevEntrega date,
	PRIMARY KEY (IdProjeto)
);

CREATE TABLE IF NOT EXISTS FaculdadeParticipaProjeto(#
	IdFaculdade int unsigned NOT NULL,
	IdProjeto int unsigned NOT NULL
);

CREATE TABLE IF NOT EXISTS OfertaDeDisciplina(#
	IdCurso int unsigned NOT NULL,
	idDisciplina int unsigned NOT NULL
);

CREATE TABLE IF NOT EXISTS Disciplina(
	idDisciplina int unsigned AUTO_INCREMENT NOT NULL,
	Cpf_Docente varchar(14) NOT NULL,
	Nome varchar(64) NOT NULL,
	MinCreditos int (5) unsigned NOT NULL,
	PRIMARY KEY (idDisciplina)
);

CREATE TABLE IF NOT EXISTS Horario(
	idDisciplina int unsigned NOT NULL,
	HoraInicio time,
	HoraFim time,
	DiaSemana varchar (3),
	Sigla varchar(64) NOT NULL,
	PRIMARY KEY (HoraInicio, HoraFim, DiaSemana, Sigla)
);

#PreRequisitoDisciplina = ( idDisciplina, idPreRequisito )
CREATE TABLE IF NOT EXISTS PreRequisitoDisciplina (#
	idDisciplina INT unsigned NOT NULL,
	IdPreRequisito INT unsigned NOT NULL,
	PRIMARY KEY (idDisciplina, IdPreRequisito)
);

#ParticipanteProjeto = ( IdProjeto, Cpf ) // Melhor para implementacao, como aluno e professor tem cpf
CREATE TABLE IF NOT EXISTS ParticipanteProjeto(#
	IdProjeto INT unsigned NOT NULL,
	Cpf VARCHAR(14) NOT NULL,
	PRIMARY KEY (IdProjeto, Cpf)
);

#Aluno = (RGA, Nome, DataNasc, Cpf_Aluno, Estado, EstadoConclusaoCurso, IdCurso, Rg,Rg_Orgao, IdEndereco	)

CREATE TABLE IF NOT EXISTS Aluno(###
	Cpf_Aluno VARCHAR(14) NOT NULL,
	RGA VARCHAR(14) NOT NULL
);

#AlunoCurso = (RGA, IdCurso, TotalCreditos)

CREATE TABLE IF NOT EXISTS AlunoCurso(#
	Cpf_Aluno VARCHAR(14) NOT NULL,
	IdCurso INT unsigned NOT NULL,
	EstadoConclusaoCurso VARCHAR(32) NOT NULL,
	TotalCreditos INT unsigned
);

#Matricula = ( RGA, idDisciplina, Desempenho, EstadoDeConclusao )

CREATE TABLE IF NOT EXISTS Matricula(#
	Cpf_Aluno VARCHAR(14) NOT NULL,
	idDisciplina INT unsigned NOT NULL,
	Desempenho FLOAT unsigned NOT NULL,
	EstadoDeConclusao VARCHAR(10)
);


#ExameAluno = ( Numero_exame , RGA, Estado )

CREATE TABLE IF NOT EXISTS ExameAluno(#
	Numero_exame INT unsigned NOT NULL,
	Cpf_Aluno VARCHAR(14) NOT NULL,
	Estado VARCHAR(10)
);

#OrientacaoAluno = ( Cpf_Docente, Cpf_Aluno )

CREATE TABLE IF NOT EXISTS OrientacaoAluno(#
	Cpf_Docente VARCHAR(14) NOT NULL,
	Cpf_Aluno VARCHAR(14) NOT NULL
);

#ParticipacaoBanca = ( IdBanca , Cpf, Participacao )

CREATE TABLE IF NOT EXISTS ParticipacaoBanca(#
	IdBanca INT unsigned NOT NULL,
	Cpf VARCHAR(14) NOT NULL,
	Participacao VARCHAR(10) NOT NULL
);


#AgenciaFinanciaPessoa = ( CPF, Nome_Agencia ) 

CREATE TABLE IF NOT EXISTS AgenciaFinanciaPessoa(#
	Cpf VARCHAR(14) NOT NULL,
	IdAgencia INT unsigned NOT NULL
);


#AgenciaFinanciaProjeto = ( IdProjeto, Nome_Agencia	)

CREATE TABLE IF NOT EXISTS AgenciaFinanciaProjeto(
	IdProjeto INT unsigned NOT NULL,
	IdAgencia INT unsigned NOT NULL
);

#Banca = ( IdBanca,Titulo,Descricao )

CREATE TABLE IF NOT EXISTS Banca(
	IdBanca INT unsigned AUTO_INCREMENT PRIMARY KEY NOT NULL,
	Data Date NOT NULL
);

CREATE TABLE IF NOT EXISTS tesesDissertacoes(
	IdBanca INT unsigned NOT NULL,
	Titulo VARCHAR(50) NOT NULL,
	Descricao VARCHAR(256)
);

#Exame = (Numero_exame,Tipo, IdBanca)

CREATE TABLE IF NOT EXISTS Exame(
	Numero_exame INT unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
	Tipo VARCHAR(10) NOT NULL,
	IdBanca INT unsigned NOT NULL
);

#Agencia = (Nome, IdEndereco)

CREATE TABLE IF NOT EXISTS Agencia(
	IdAgencia INT unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Nome VARCHAR(50) NOT NULL,
	IdEndereco INT unsigned NOT NULL
);

ALTER TABLE Agencia
	ADD CONSTRAINT FOREIGN KEY (IdEndereco) REFERENCES Endereco(IdEndereco);

ALTER TABLE PreRequisitoDisciplina
	ADD CONSTRAINT FOREIGN KEY (idDisciplina) REFERENCES Disciplina(idDisciplina),
	ADD CONSTRAINT FOREIGN KEY (IdPreRequisito) REFERENCES Disciplina(idDisciplina);

ALTER TABLE ParticipanteProjeto
	ADD CONSTRAINT FOREIGN KEY (IdProjeto) REFERENCES Projeto (IdProjeto);

ALTER TABLE AlunoCurso
	ADD CONSTRAINT FOREIGN KEY (Cpf_Aluno) REFERENCES Pessoa(Cpf),
	ADD CONSTRAINT FOREIGN KEY (IdCurso) REFERENCES Curso (IdCurso);

ALTER TABLE Matricula
	ADD CONSTRAINT FOREIGN KEY (Cpf_Aluno) REFERENCES Pessoa(Cpf),
	ADD CONSTRAINT FOREIGN KEY (idDisciplina) REFERENCES Disciplina(idDisciplina);

ALTER TABLE ExameAluno
	ADD CONSTRAINT FOREIGN KEY (Cpf_Aluno) REFERENCES Pessoa(Cpf),
	ADD CONSTRAINT FOREIGN KEY (Numero_exame) REFERENCES Exame(Numero_exame);

ALTER TABLE OrientacaoAluno
	ADD CONSTRAINT FOREIGN KEY (Cpf_Docente) REFERENCES Pessoa(Cpf),
	ADD CONSTRAINT FOREIGN KEY (Cpf_Aluno) REFERENCES Pessoa(Cpf);

ALTER TABLE ParticipacaoBanca
	ADD CONSTRAINT FOREIGN KEY (IdBanca) REFERENCES Banca(IdBanca);

ALTER TABLE AgenciaFinanciaPessoa
	ADD CONSTRAINT FOREIGN KEY (IdAgencia) REFERENCES Agencia(IdAgencia);

ALTER TABLE AgenciaFinanciaProjeto
	ADD CONSTRAINT FOREIGN KEY (IdProjeto) REFERENCES Projeto (IdProjeto),
	ADD CONSTRAINT FOREIGN KEY (IdAgencia) REFERENCES Agencia(IdAgencia);
	
ALTER TABLE Exame
	ADD CONSTRAINT FOREIGN KEY (IdBanca) REFERENCES Banca(IdBanca);

ALTER TABLE tesesDissertacoes
	ADD CONSTRAINT FOREIGN KEY (IdBanca) REFERENCES Banca(IdBanca);

#Adequação das tabelas para as chaves estrangeiras
ALTER TABLE Curso
  ADD CONSTRAINT FOREIGN KEY (IdFaculdade) REFERENCES Faculdade (IdFaculdade),
  ADD CONSTRAINT FOREIGN KEY (Cpf_Coordenador) REFERENCES Coordenador (Cpf_Docente),
  ADD CONSTRAINT FOREIGN KEY (Cpf_Vice_coordenador) REFERENCES Vice_coordenador (Cpf_Docente);

ALTER TABLE Professor
  ADD CONSTRAINT FOREIGN KEY (Cpf_Docente) REFERENCES Pessoa (CPF);###
ALTER TABLE Coordenador
  ADD CONSTRAINT FOREIGN KEY (Cpf_Docente) REFERENCES Pessoa (CPF);###
ALTER TABLE Vice_coordenador
  ADD CONSTRAINT FOREIGN KEY (Cpf_Docente) REFERENCES Pessoa (CPF);###

ALTER TABLE Faculdade
  ADD CONSTRAINT FOREIGN KEY (IdEndereco) REFERENCES Endereco(IdEndereco);###

ALTER TABLE Laboratorio
  ADD CONSTRAINT FOREIGN KEY (IdFaculdade) REFERENCES Faculdade (IdFaculdade);

ALTER TABLE FaculdadeParticipaProjeto
  ADD CONSTRAINT FOREIGN KEY (IdFaculdade) REFERENCES Faculdade (IdFaculdade),
  ADD CONSTRAINT FOREIGN KEY (IdProjeto) REFERENCES Projeto (IdProjeto);
ALTER TABLE OfertaDeDisciplina
  ADD CONSTRAINT FOREIGN KEY (IdCurso) REFERENCES Curso (IdCurso),
  ADD CONSTRAINT FOREIGN KEY (idDisciplina) REFERENCES Disciplina (idDisciplina);

ALTER TABLE Disciplina
  ADD CONSTRAINT FOREIGN KEY (Cpf_Docente) REFERENCES Professor (Cpf_Docente);

ALTER TABLE Horario
  ADD CONSTRAINT FOREIGN KEY (idDisciplina) REFERENCES Disciplina (idDisciplina),
  ADD CONSTRAINT FOREIGN KEY (Sigla) REFERENCES Laboratorio (Sigla);

ALTER TABLE Aluno
	ADD CONSTRAINT FOREIGN KEY (Cpf_Aluno) REFERENCES Pessoa (CPF);###