<?php
/*
 * Menu navbar, just an unordered list
 * Username input text box and login logout buttons base on the action
 */
?>
<h2>BotTrader Web App</h2>

<ul class="nav">
    {menudata}
    <li><a href="{link}">{name}</a></li>
    {/menudata}
</ul>

<div id="loginbox">         
    <div id="welcomemsg">{welcome_txt}</div>
    <div id="logintext">{login_msg}</div>
    <table>
        <tr>
            <th>Login</th>
            <th>Register</th>
        </tr>
        <tr>
            <td>
                <form name="loginform" id="loginform" action= "" method="POST">
                    <input type="text" name="username" placeholder="Username" >
                    <input type="text" name="action" value="{login_action}" style="display:none">
                    <input type="submit" value="{login_submit_txt}">                    
                </form>    
            </td>
            <td> 
                <form name="registration" id="registration" action= "" method="POST">
                    <input type="text" name="team" placeholder="Team" >
                    <input type="text" name="name" placeholder="Name" >
                    <input type="text" name="password" placeholder="Password" >
                    <input type="text" name="regaction" value="{register_action}" style="display:none">
                    <input type="submit" value="{register_submit_txt}">
                </form>  
            </td>
        </tr>
    </table>

</div>
