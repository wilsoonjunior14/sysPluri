## sysPluri - API Rest com Laravel
## Requisitos
<ul>
  <li>PHP 7</li>
  <li>Composer</li>
  <li>MySQL</li>
</ul>

## Iniciando a aplicação
<ul>
  <li>Baixando o projeto pelo git: <b>git clone https://github.com/wilsoonjunior14/sysPluri.git</b></li>
  <li>Após isso, ir até a pasta do projeto via cmd e usar o comando: <b>composer install</b></li>
  <li>Verificar conexão com a base de dados no arquivo .env localizado na raiz do projeto</li>
  <li>Rodar o comando <b>php artisan migrate</b> para criar as tabelas na base de dados</li>
  <li>Rodar o projeto com o comando <b>php artisan serve</b> ou colocar o projeto na pasta <b>htdocs</b> do <b>xampp</b> por exemplo</li>
  <li>Verificar se as rotas estão funcionando adequadamente. Por exemplo: <b>http://localhost:8000/api/aluno</b> para retornar a lista de alunos</li>
  <li>Para executar os testes automáticos basta rodar o comando: <b>./vendor/bin/phpunit</b> na raiz do projeto pelo terminal ou cmd</li>
</ul>

## Rotas da API
# Rotas de aluno
- get api/aluno
- get api/aluno/{id}
- post api/aluno
- put api/aluno
- delete api/aluno
- post api/aluno/buscar

# Rotas do curso
- get api/curso
- get api/curso/{id}
- post api/curso
- put api/curso
- delete api/curso

# Rotas da matricula
- get api/matricula
- get api/matricula/{id}
- post api/matricula
- put api/matricula
- delete api/matricula

# Buscar informações sobre sexo e cursos
- get api/buscar

## Alguns prints da API
<img src='https://raw.githubusercontent.com/wilsoonjunior14/sysPluri/master/img1.png' />
<img src='https://raw.githubusercontent.com/wilsoonjunior14/sysPluri/master/img2.png' />
<img src='https://raw.githubusercontent.com/wilsoonjunior14/sysPluri/master/img3.png' />
<img src='https://raw.githubusercontent.com/wilsoonjunior14/sysPluri/master/img4.png' />
