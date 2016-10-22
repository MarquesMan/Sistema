# Nome de alunos de um determinado curso
SELECT Nome
FROM (ALUNO AS A JOIN AlunoCurso AS AC ON A.Cpf_Aluno=AC.Cpf_Aluno)
WHERE IdCurso =(SELECT C.IdCurso
				FROM Curso as C
				WHERE C.Nome="Ciência da Computação")

# teses e dissertações em que um determinado professor participou
SELECT Titulo,Descricao,Participacao
FROM tesesDissertacoes NATURAL JOIN ParticipacaoBanca 
WHERE Cpf="958.355.478-20"

# Professores externos que participam de Bancas de defesa ou de tese 
SELECT DISTINCT Nome 
FROM ParticipacaoBanca as PB JOIN ProfessorExterno as PE ON PB.CPF = PE.Cpf_Docente

# Professores que também são coordenadores/vice-coordenadores
SELECT NOME,Cpf_Docente
FROM PROFESSOR NATURAL JOIN Coordenador
UNION
SELECT NOME,Cpf_Docente
FROM PROFESSOR NATURAL JOIN Vice_coordenador

# Agencias que financia um determinado projeto
SELECT Agencia.Nome
FROM Agencia NATURAL JOIN AgenciaFinanciaProjeto JOIN Projeto
WHERE Projeto.Nome="Sistema de Estágios"

# endereco de determinado um aluno
SELECT *
FROM endereco
WHERE IdEndereco = ( SELECT IdEndereco
					 FROM Aluno
					 WHERE Cpf_Aluno="482.720.536-16")

# Quais laboratorios um determinada faculdade possui
SELECT Sigla, Laboratorio.Nome
FROM Laboratorio JOIN Faculdade on Laboratorio.idFaculdade=Faculdade.idFaculdade
WHERE Faculdade.Nome="Universidade Universal do Universo"

# Nome das Disciplinas em que um aluno foi aprovado
SELECT Nome
FROM Matricula NATURAL JOIN Disciplina
WHERE Cpf_Aluno="482.720.536-16" AND EstadoDeConclusao="Aprovado"

# Prerequisitos de uma disciplina
SELECT Nome
FROM PreRequisitoDisciplina JOIN Disciplina ON Disciplina.idDisciplina=PreRequisitoDisciplina.IdPreRequisito
WHERE PreRequisitoDisciplina.idDisciplina =( SELECT idDisciplina
											 FROM Disciplina
											 WHERE Nome="Grafos")

# exames de um aluno
SELECT Exame.Tipo, ExameAluno.Estado
FROM ExameAluno NATURAL JOIN Exame
WHERE Cpf_Aluno="482.720.536-16"

# Alunos orientados por um professor
SELECT Aluno.Nome,Aluno.Cpf_Aluno 
FROM Aluno NATURAL JOIN OrientacaoAluno
WHERE Cpf_Docente="958.355.478-20"

# Alunos financiados por uma agencia
SELECT Aluno.Nome 
FROM AgenciaFinanciaPessoa as A JOIN Aluno ON A.Cpf=Aluno.Cpf_Aluno JOIN Agencia
WHERE Agencia.Nome="Netfix"