# Documento de Especificação de Requisitos de Software (ERS)

## 1. Introdução

Este documento de Especificação de Requisitos de Software (ERS) detalha as funcionalidades e restrições do sistema **PresenTrack**. O PresenTrack é uma aplicação web desenvolvida com o objetivo principal de gerenciar e registrar a assiduidade (presença/ausência) de estudantes em um ambiente acadêmico.

### 1.1 Escopo do Sistema

O sistema PresenTrack abrange as operações essenciais de gestão de estudantes, registo de presenças, consultas históricas e geração de relatórios de assiduidade. O sistema deve ser acessível por administradores e professores autenticados.

---

## 2. Requisitos Funcionais (RF)

Os Requisitos Funcionais definem as funções que o sistema PresenTrack deve ser capaz de executar.

| ID | Módulo | Requisito Funcional | Descrição Detalhada |
|---|---|---|---|
| **RF01** | Autenticação | Login de Usuários | O sistema deve permitir que administradores e professores realizem login utilizando credenciais (email/username e senha) válidas. |
| **RF02.1** | Gestão de Estudantes | Cadastro de Estudantes | O sistema deve permitir que o usuário cadastre novos estudantes, registrando informações como nome, matrícula e dados de contato. |
| **RF02.2** | Gestão de Estudantes | Edição de Dados | O sistema deve permitir a modificação de dados de estudantes previamente cadastrados. |
| **RF02.3** | Gestão de Estudantes | Remoção de Estudantes | O sistema deve permitir a exclusão de registos de estudantes. |
| **RF02.4** | Gestão de Estudantes | Listagem de Estudantes | O sistema deve exibir uma lista completa de todos os estudantes cadastrados. |
| **RF03** | Presenças | Marcação de Presença | O sistema deve permitir ao usuário marcar o status de assiduidade de um estudante como Presente ou Ausente. |
| **RF04** | Consultas | Consulta por Data | O usuário deve ser capaz de selecionar uma data específica e visualizar todos os registos de assiduidade realizados nesse dia. |
| **RF05** | Consultas | Histórico Individual | O sistema deve ser capaz de gerar e exibir o histórico completo de assiduidade (presente, ausente) de um estudante selecionado. |
| **RF06** | Relatórios | Relatórios Básicos | O sistema deve gerar relatórios visuais contendo o percentual de presenças por aluno e o total de faltas em um período definido. |
| **RF07** | Gestão de Turmas | Criação de Turmas | O sistema deve permitir a criação de turmas/salas de aula e a associação de estudantes a essas turmas. |
| **RF08** | Usabilidade | Pesquisa Rápida | O sistema deve implementar uma funcionalidade de pesquisa em tempo real (utilizando JavaScript) para localizar estudantes pelo nome. |
| **RF09** | Presenças | Registo de Hora Automático | O sistema deve armazenar automaticamente o carimbo de data e hora exato em que cada marcação de presença foi registrada. |
| **RF10** | Autenticação | Logout | O usuário deve ser capaz de encerrar sua sessão de trabalho de maneira segura a qualquer momento. |

---

## 3. Requisitos Não Funcionais (RNF)

Os Requisitos Não Funcionais definem as qualidades, restrições e características técnicas do sistema PresenTrack.

| ID | Categoria | Requisito Não Funcional | Descrição e Justificativa |
|---|---|---|---|
| **RNF01** | Usabilidade | Interface Otimizada | A interface do usuário deve ser intuitiva, simples e clara, otimizada para minimizar o tempo de interação e o número de erros de registo. |
| **RNF02** | Desempenho | Tempo de Resposta | As operações básicas do sistema (login, registo de presença, consultas) devem ser concluídas em tempo inferior a 1 segundo para garantir uma sensação de fluidez e produtividade. |
| **RNF03** | Segurança | Armazenamento de Credenciais | Todas as senhas de usuários devem ser armazenadas no banco de dados utilizando uma função de hashing criptográfico (e.g., Argon2, bcrypt) para protegê-las contra acesso direto. |
| **RNF04** | Portabilidade | Compatibilidade com Navegadores | O sistema web deve ser totalmente funcional e ter renderização consistente em todos os principais navegadores modernos (Google Chrome, Mozilla Firefox, Microsoft Edge). |
| **RNF05** | Manutenibilidade | Arquitetura em Camadas | O código da aplicação deve ser estruturado em camadas distintas: apresentação (HTML/CSS/JS), lógica de negócio (JavaScript) e servidor (PHP), facilitando a manutenção e a evolução. |
| **RNF06** | Escalabilidade | Suporte de Carga | A aplicação deve ser capaz de suportar um volume de, no mínimo, 100 estudantes cadastrados e seus respetivos registos de presença sem apresentar degradação perceptível de desempenho. |
| **RNF07** | Armazenamento | Tipo de Banco de Dados | Os dados persistentes (usuários, estudantes, presenças) devem ser armazenados em um Banco de Dados Relacional (como MySQL ou MariaDB), garantindo a consistência e integridade referencial dos dados. |
| **RNF08** | Acessibilidade | Design Inclusivo | A interface deve aderir a princípios básicos de acessibilidade, incluindo contraste de cores adequado e espaçamento suficiente para elementos clicáveis (touch targets), melhorando a experiência para todos os usuários. |
| **RNF09** | Confiabilidade | Integridade do Registo | O sistema deve incluir mecanismos (como transações de banco de dados) para evitar a perda ou corrupção de dados durante as operações de registo e atualização de assiduidade. |
| **RNF10** | Organização do Código | Separação de Tecnologias | O código-fonte deve evitar a mistura excessiva de diferentes tecnologias (e.g., CSS inline, PHP misturado a HTML), promovendo a organização e adesão a boas práticas de desenvolvimento (Separação de Preocupações). |

---

**Fim do Documento de Requisitos de Software.**
