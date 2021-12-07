<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html><head><title>Login</title>
        <link rel="stylesheet"  href="Estilo/style.css" >
        <script type="text/javascript">
            
            function validar(){
                var email_log = formLogin.email_login.value;
                var senha_log = formLogin.senha_login.value;
                
                if(email_log === ""){
                    alert ('Preencha o campo com seu email');
                    formLogin.email_login.focus();
                   return false;
               }
                    if(senha_log === ""){
                        alert('Preencha o campo com sua senha');
                        formLogin.senha_login.focus();
                        return false;
                    }
                    document.formLogin.submit();
                }
            }
            </script>
        <body>
            <h1>Gerenciador de Dados do Funcionario</h1>
            <<main class="container">
                <div class="container">
                        <div class="content">
                    <!FORMULARIO LOGIN!>
                        <div id="login">
                                <form name="formLogin" method="post" action="ValidaLogin.php">
                                    <h1>Login</h1>
                                        <p>
                                            <label for="email_login">Seu e-mail</label>
                                            <input id="email_login" name="email" maxlength="50"
                                                   required="required" type="text"
                                                   placeholder="ex.contato@empresa.com"/>
                                    </p>
                                    
                                        <p>
                                            <label for="senha_login">Sua senha</label>
                                            <input id="senha_login" name="senha" maxlength="8"
                                                  required="required" type="password"
                                                  placeholder="ex.12345678" />                                       
                                    </p>
                                    
                                        <p>
                                            <input type="submit" value="Logar" onclick="return validar()"/>
                                    </p>
                                    
                                        <p class="link">
                                    Ainda não tem conta?
                                    <a href="index.php">Cadastre-se</a>
                                    </p>
                            </form>
                    </div>
                    </div>
            </div>
            </main> 
    </body>
    </html>