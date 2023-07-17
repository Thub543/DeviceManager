<h1> How to generate tables</h1>
<h3>Login daten</h3>
Für Admin: username: admin pw: 1234 <br>
Für ReadOnly: username: ro pw:1234



<h3>Vorrausetzungen</h3>
<p>Laufender Docker Container sqlserver2019</p>
<h3>Steps</h3>
<p>1. einmalig eine db erstellen mittels dbeaver o. Ä mit dem Namen "Assetsdb" <- genau so</p>
<p>2. Mit terminal in den www ordner</p>
<p>3. Mit dem Befehl php artisan migrate:fresh werden alle tabellen erzeugt</p>



<h2>Helpful commands in laravel</h2>
<p> "php artisan migrate:fresh -seed" ladet das datenbankmodel von neu fügt die test daten nochmal von neu</p>
