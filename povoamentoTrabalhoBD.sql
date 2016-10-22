USE SCA;

INSERT INTO Endereco( Rua, Numero, Bairro, Cidade, Estado,Complemento,CEP ) VALUES
("Dolores da Flor","1","Jardim das Palmeiras","Campo Grande","MS","","79113012"),
("Dos Bobos","0","Derpelandia 3","Campo Grande","MS","","79113012"),
("Mario Covas","150","Romero Britto Seuku","Campo Grande","MS","","79113012"),
("São Paulo","255","Recanto dos Países","Campo Grande","MS","","79113012"),
("Margarida Oléro","1","Recanto do Sabiá","Campo Grande","MS","","79113012"),
("Cogumelo Rodrigues","7","Mata do Jacinto","Campo Grande","MS","","79113012"),
("Flor Randomia","32","Coimbra III","Campo Grande","MS","","79113012"),
("Abacate Roma","17","Alto Sobrinho","Campo Grande","MS","","79113012"),
("Analpolis","4","Cufftze","Campo Grande","MS","","79113012");

INSERT INTO Banca(Data) VALUES
("2008-11-11"),
("2009-11-11"),
("2010-11-11");

INSERT INTO Pessoa(CPF,Nome,DataNasc,IdEndereco) VALUES
("958.355.478-20","José Ferreira","1964-03-02","1"),
("570.889.712-08","José Félix","1980-05-15","3"),
("481.654.818-19","José Ferreira","1975-07-12","2"),
("354.079.656-82","Ana Paula","1980-05-15","2"),
("504.557.749-27","Ana Flavia","1980-05-15","2"),
("127.567.214-09","Henrique Fernandes","1964-03-02","4"),
("393.547.438-54","Yan Costa","1975-08-10","6"),
("314.575.143-38","Bueno Dias","1987-12-21","5"),
("444.253.536-16","Matheus da Silva","1980-10-11","6"),
("482.720.536-16","Antônio da Silva","1996-07-06","6");

INSERT INTO Professor(Cpf_Docente) VALUES
("958.355.478-20"),
("570.889.712-08"),
("481.654.818-19");

INSERT INTO ProfessorExterno(Cpf_Docente) VALUES
("354.079.656-82"),
("504.557.749-27");

INSERT INTO Coordenador(Cpf_Docente) VALUES
("958.355.478-20"),
("127.567.214-09"),
("481.654.818-19");

INSERT INTO Vice_coordenador(Cpf_Docente) VALUES
("314.575.143-38"),
("393.547.438-54"),
("570.889.712-08");

INSERT INTO Faculdade(Nome,IdEndereco) VALUES
("Universidade Universal do Universo","7"),
("ITA - Instituto de Trico de Aquidauna","8");

INSERT INTO Curso(Nome,Cpf_Coordenador,Cpf_Vice_coordenador,IdFaculdade,CreditosParaConclusao) VALUES
("Ciência da Computação","958.355.478-20","570.889.712-08","1",40),
("Engenharia da Computação","481.654.818-19","314.575.143-38","2",50),
("Engenharia Civil","127.567.214-09","393.547.438-54","1",45);


INSERT INTO Laboratorio(Nome,Sigla,IdFaculdade) VALUES
("Laboratorio de Sistemas Computacionais de Alto Desempenho","LSCAD", "1"),
("Laboratorio de Física Aplicada","LFA","2");

INSERT INTO Projeto(Nome,Area,DataInicio,PrevEntrega) VALUES
("Sistema de Estágios","Desenvolvimento Web","2014-06-15","2015-06-15"),
("Classificação de Milho","Inteligência Artificial","2013-02-12","2015-03-15");

INSERT INTO Disciplina(Cpf_Docente,Nome,MinCreditos) VALUES
("958.355.478-20","Grafos",30),
("481.654.818-19","Vetores e Geometria Analítica", 6),
("570.889.712-08","Algoritmos e Programação",0);

INSERT INTO OfertaDeDisciplina(IdCurso,idDisciplina) VALUES
("1","2"),
("2","1");

INSERT INTO FaculdadeParticipaProjeto(IdFaculdade,IdProjeto) VALUES
("1","1"),
("2","2");

INSERT INTO Horario(idDisciplina,HoraInicio,HoraFim,DiaSemana,Sigla) VALUES
("1","14:00:00","18:00:00","TER","LSCAD"),
("1","14:00:00","18:00:00","SEX","LSCAD"),
("2","7:00:00","11:00:00","SEG","LFA"),
("2","13:00:00","15:00:00","QUA","LFA"),
("3","13:00:00","15:00:00","QUI","LSCAD");

INSERT INTO PreRequisitoDisciplina(idDisciplina,IdPreRequisito) VALUES
("1","2"),
("2","3");

INSERT INTO Aluno(RGA,Cpf_Aluno) VALUES
("201319040127","444.253.536-16"),
("201319040129","482.720.536-16");


INSERT INTO ParticipanteProjeto(IdProjeto,Cpf) VALUES
("1","958.355.478-20"),
("2","570.889.712-08"),
("2","201319040129");

INSERT INTO AlunoCurso(Cpf_Aluno,IdCurso,EstadoConclusaoCurso,TotalCreditos) VALUES
("482.720.536-16","1","Cursando",0);

INSERT INTO ParticipacaoBanca(IdBanca,Cpf,Participacao) VALUES
("1","354.079.656-82","Juri"),
("1","958.355.478-20","Juri"),
("2","958.355.478-20","Defensor"),
("1","504.557.749-27","Juri");

INSERT INTO Matricula(Cpf_Aluno,idDisciplina,Desempenho,EstadoDeConclusao) VALUES
("482.720.536-16","1","9.0","Aprovado"),
("482.720.536-16","2","3.0","Reprovado"),
("482.720.536-16","3","5.0","Cursando");

INSERT INTO OrientacaoAluno(Cpf_Docente,Cpf_Aluno) VALUES
("958.355.478-20","482.720.536-16"); 

INSERT INTO Agencia(Nome,IdEndereco) VALUES
("NetFix","9");

INSERT INTO AgenciaFinanciaPessoa(Cpf,IdAgencia) VALUES
("958.355.478-20","1");

INSERT INTO AgenciaFinanciaProjeto(IdProjeto,IdAgencia) VALUES
("1","1");	

INSERT INTO Exame(Numero_exame,Tipo,IdBanca) VALUES
(1,"Qualificação","1"),
(2,"Proficiência","2");

INSERT INTO ExameAluno(Numero_exame,Cpf_Aluno,Estado) VALUES
(1,"482.720.536-16","Aprovado"),
(2,"482.720.536-16","Aprovado");

INSERT INTO tesesDissertacoes(IdBanca,Titulo,Descricao) VALUES
(1,"Projeto Genoma","cromossomos!"),
(1,"Física de Fluídos","líquidos!"),
(2,"Jogos eletronicos na crescimento de leguminosas","Batata");