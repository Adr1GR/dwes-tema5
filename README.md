<div class="page">
  <header class="mobile-header scrolled">
    <div class="header-left">
      <label class="nav-overlay-icon" for="__navigation">
        <div class="visually-hidden">Toggle site navigation sidebar</div>
        <i class="icon"><svg><use href="#svg-menu"></use></svg></i>
      </label>
    </div>
    <div class="header-center">
      <a href="index.html"><div class="brand">Acceso a datos</div></a>
    </div>
    <div class="header-right">
      <div class="theme-toggle-container theme-toggle-header">
        <button class="theme-toggle">
          <div class="visually-hidden">Toggle Light / Dark / Auto color theme</div>
          <svg class="theme-icon-when-auto"><use href="#svg-sun-half"></use></svg>
          <svg class="theme-icon-when-dark"><use href="#svg-moon"></use></svg>
          <svg class="theme-icon-when-light"><use href="#svg-sun"></use></svg>
        </button>
      </div>
      <label class="toc-overlay-icon toc-header-icon" for="__toc">
        <div class="visually-hidden">Toggle table of contents sidebar</div>
        <i class="icon"><svg><use href="#svg-toc"></use></svg></i>
      </label>
    </div>
  </header>
  <aside class="sidebar-drawer">
    <div class="sidebar-container">
      
      <div class="sidebar-sticky"><a class="sidebar-brand" href="index.html">
  
  
  <span class="sidebar-brand-text">Acceso a datos</span>
  
</a><form class="sidebar-search-container" method="get" action="search.html" role="search">
  <input class="sidebar-search" placeholder="Búsqueda" name="q" aria-label="Búsqueda">
  <input type="hidden" name="check_keywords" value="yes">
  <input type="hidden" name="area" value="default">
</form>
<div id="searchbox"></div><div class="sidebar-scroll"><div class="sidebar-tree">
  <ul class="current">
<li class="toctree-l1"><a class="reference internal" href="practica_guiada.html">Práctica guiada: BlogDWES</a></li>
<li class="toctree-l1"><a class="reference internal" href="intro_db_php.html">Bases de datos</a></li>
<li class="toctree-l1"><a class="reference internal" href="prepara_tu_entorno.html">PHP, Apache y MariaDB: prepara tu entorno de desarrollo</a></li>
<li class="toctree-l1"><a class="reference internal" href="mysqli.html">MariaDB en PHP con mysqli</a></li>
<li class="toctree-l1 current current-page"><a class="current reference internal" href="#">Práctica: galería de imágenes</a></li>
</ul>

</div>
</div>

      </div>
      
    </div>
  </aside>
  <div class="main">
    <div class="content">
      <div class="article-container">
        <a href="#" class="back-to-top muted-link">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M13 20h-2V8l-5.5 5.5-1.42-1.42L12 4.16l7.92 7.92-1.42 1.42L13 8v12z"></path>
          </svg>
          <span>Back to top</span>
        </a>
        <div class="content-icon-container">
          <div class="theme-toggle-container theme-toggle-content">
            <button class="theme-toggle">
              <div class="visually-hidden">Toggle Light / Dark / Auto color theme</div>
              <svg class="theme-icon-when-auto"><use href="#svg-sun-half"></use></svg>
              <svg class="theme-icon-when-dark"><use href="#svg-moon"></use></svg>
              <svg class="theme-icon-when-light"><use href="#svg-sun"></use></svg>
            </button>
          </div>
          <label class="toc-overlay-icon toc-content-icon" for="__toc">
            <div class="visually-hidden">Toggle table of contents sidebar</div>
            <i class="icon"><svg><use href="#svg-toc"></use></svg></i>
          </label>
        </div>
        <article role="main">
          <section id="practica-galeria-de-imagenes">
<h1>Práctica: galería de imágenes<a class="headerlink" href="#practica-galeria-de-imagenes" title="Enlazar permanentemente con este título">#</a></h1>
<section id="repositorio-de-github" class="">
<h2>Repositorio de GitHub<a class="headerlink" href="#repositorio-de-github" title="Enlazar permanentemente con este título">#</a></h2>
<p>Crea un <strong>repositorio en GitHub</strong> llamado <strong>dwes-tema5</strong> donde subirás el código de esta práctica.</p>
</section>
<section id="descripcion-general-de-la-practica" class="">
<h2>Descripción general de la práctica<a class="headerlink" href="#descripcion-general-de-la-practica" title="Enlazar permanentemente con este título">#</a></h2>
<p>En esta práctica tienes que descargarte el <a class="reference external" href="_static/galeria.zip">siguiente proyecto</a> y terminarla. En el código fuente tienes, a través de comentarios, la descripción de lo que tiene que hacer cada uno de los scripts.</p>
<p>Dicho proyecto consiste en una galería de imágenes que los usuarios registrados pueden subir.</p>
<ul class="simple">
<li><p><code class="file docutils literal notranslate"><span class="pre">index.php</span></code>: en este script se muestran todas las imágenes que hay en la base de datos.</p></li>
<li><p><code class="file docutils literal notranslate"><span class="pre">filter.php</span></code>: este script permite a los usuarios buscar imágens por el nombre.</p></li>
<li><p><code class="file docutils literal notranslate"><span class="pre">add.php</span></code>: este es el script que, a través de un formulario, permite <strong>a los usuarios registrados y logeados</strong> añadir nuevas imágenes.</p></li>
<li><p><code class="file docutils literal notranslate"><span class="pre">delete.php</span></code>: este es el script a través del cual se elimina una imagen. Solo un <strong>usuario registrado y logeado</strong> puede realizar tal acción.</p></li>
<li><p><code class="file docutils literal notranslate"><span class="pre">signup.php</span></code>: este script permite, vía formulario, registrarse a un usuario.</p></li>
<li><p><code class="file docutils literal notranslate"><span class="pre">login.php</span></code>: este es el script que pueden usar los usuarios para iniciar sesión.</p></li>
<li><p><code class="file docutils literal notranslate"><span class="pre">logout.php</span></code>: este otro script permite cerrar la sesión a un usuario <strong>logeado</strong>.</p></li>
</ul>
<p>Al margen de todos estos scripts, puedes crear otros scripts si lo necesites y lo crees conveniente.</p>
</section>
<section id="sistema-de-informacion" class="">
<h2>Sistema de información<a class="headerlink" href="#sistema-de-informacion" title="Enlazar permanentemente con este título">#</a></h2>
<p>En la carpeta <code class="file docutils literal notranslate"><span class="pre">bd/</span></code> puedes ver el <strong>esquema de la base de datos</strong> que tienes en un fichero <code class="file docutils literal notranslate"><span class="pre">schema.sql</span></code> con las sentencias <strong>CREATE TABLE</strong> necesarias para <em>montar</em> la base de datos.</p>
<p>Fíjate bien en los campos de las tablas, las relaciones y qué campos son obligatorios.</p>
<p>Como ves, la tabla <strong>imagen</strong> tiene un campo llamado <strong>subido</strong> que contiene la fecha (<em>timestamp</em>) en la que se ha subido la imagen. Usa, en el <strong>INSERT</strong> que corresponda la función <strong>UNIX_TIMESTAMP()</strong> de MariaDB como ya hicimos en la práctica guiada.</p>
</section>
<section id="organizacion-del-codigo" class="">
<h2>Organización del código<a class="headerlink" href="#organizacion-del-codigo" title="Enlazar permanentemente con este título">#</a></h2>
<p>Como ves en los comentarios en los diferentes scripts, están marcados los lugares donde tiene que ir la lógica y la vista. No cumplir con este requisito supondrá una merma en la calificación de dicho script del 25%.</p>
</section>
<section id="configurar-entorno-de-desarrollo" class="">
<h2>Configurar entorno de desarrollo<a class="headerlink" href="#configurar-entorno-de-desarrollo" title="Enlazar permanentemente con este título">#</a></h2>
<p>Lee el fichero <code class="file docutils literal notranslate"><span class="pre">DEVELOPMENT.md</span></code> en el que se dan las instrucciones necesarias para poner en marcha el entorno de desarrollo a través de Docker.</p>
</section>
<section id="planificacion" class="">
<h2>Planificación<a class="headerlink" href="#planificacion" title="Enlazar permanentemente con este título">#</a></h2>
<p>Te indico las horas planificadas para el desarrollo de esta práctica, que serán las horas que voy a dejar en clase para hacerla:</p>
<ul class="simple">
<li><p><code class="file docutils literal notranslate"><span class="pre">index.php</span></code>: este script ya está hecho, así que hay planificado para el desarrollo del mismo 0 horas</p></li>
<li><p><code class="file docutils literal notranslate"><span class="pre">filter.php</span></code>: 1 hora</p></li>
<li><p><code class="file docutils literal notranslate"><span class="pre">signup.php</span></code>: 1,5 horas</p></li>
<li><p><code class="file docutils literal notranslate"><span class="pre">login.php</span></code>: 0,5 horas</p></li>
<li><p><code class="file docutils literal notranslate"><span class="pre">logout.php</span></code>: 0,5 horas</p></li>
<li><p><code class="file docutils literal notranslate"><span class="pre">add.php</span></code>: 2 horas</p></li>
<li><p><code class="file docutils literal notranslate"><span class="pre">delete.php</span></code>: 0,5 horas</p></li>
<li><p>Imprevistos varios: 1 hora</p></li>
</ul>
<p>En total, vamos a dedicar en clase 7, es decir, 7 sesiones.</p>
</section>
<section id="criterios-de-calificacion" class="">
<h2>Criterios de calificación<a class="headerlink" href="#criterios-de-calificacion" title="Enlazar permanentemente con este título">#</a></h2>
<p>Cada script tiene un peso que te indico abajo. Se restará nota en estos casos:</p>
<ul class="simple">
<li><p>25%: se mezcla la lógica y la vista.</p></li>
<li><p>25%: errores leves como crear variables que no se necesitan.</p></li>
<li><p>50%: errores graves como no se ha validado y/o saneado en tales casos, no se gestiona bien el menú de navegación, no se ha usado sentecias preparadas cuando hay que incluirvalores de variables, etc.</p></li>
<li><p>100%: errores graves como permitir el acceso al script a usuarios no registrados/logeados, no se realiza correctamente la gestión de la autenticación, etc.</p></li>
</ul>
<p>Pesos de los diferentes scripts:</p>
<ul class="simple">
<li><p><code class="file docutils literal notranslate"><span class="pre">filter.php</span></code>: 20%</p></li>
<li><p><code class="file docutils literal notranslate"><span class="pre">signup.php</span></code>: 20%</p></li>
<li><p><code class="file docutils literal notranslate"><span class="pre">login.php</span></code>: 20%</p></li>
<li><p><code class="file docutils literal notranslate"><span class="pre">logout.php</span></code>: 10%</p></li>
<li><p><code class="file docutils literal notranslate"><span class="pre">add.php</span></code>: 20%</p></li>
<li><p><code class="file docutils literal notranslate"><span class="pre">delete.php</span></code>: 10%</p></li>
</ul>
</section>
</section>

        </article>
      </div>
      <footer>
        
        <div class="related-pages">
          
          <a class="prev-page" href="mysqli.html">
              <svg><use href="#svg-arrow-right"></use></svg>
              <div class="page-info">
                <div class="context">
                  <span>Previous</span>
                </div>
                
                <div class="title">MariaDB en PHP con mysqli</div>
                
              </div>
            </a>
        </div>
        <div class="bottom-of-page">
          <div class="left-details">
            <div class="copyright">
                Copyright © 2022, Román Ginés Martínez Ferrández
            </div>
            Made with 
            <a href="https://github.com/pradyunsg/furo">Furo</a>
            
          </div>
          <div class="right-details">
            <div class="icons">
              
            </div>
          </div>
        </div>
        
      </footer>
    </div>
    <aside class="toc-drawer">
      
      
      <div class="toc-sticky toc-scroll">
        <div class="toc-title-container">
          <span class="toc-title">
            Contenidos
          </span>
        </div>
        <div class="toc-tree-container">
          <div class="toc-tree">
            <ul>
<li><a class="reference internal" href="#">Práctica: galería de imágenes</a><ul>
<li class=""><a class="reference internal" href="#repositorio-de-github">Repositorio de GitHub</a></li>
<li class=""><a class="reference internal" href="#descripcion-general-de-la-practica">Descripción general de la práctica</a></li>
<li class=""><a class="reference internal" href="#sistema-de-informacion">Sistema de información</a></li>
<li class=""><a class="reference internal" href="#organizacion-del-codigo">Organización del código</a></li>
<li class=""><a class="reference internal" href="#configurar-entorno-de-desarrollo">Configurar entorno de desarrollo</a></li>
<li class=""><a class="reference internal" href="#planificacion">Planificación</a></li>
<li class=""><a class="reference internal" href="#criterios-de-calificacion">Criterios de calificación</a></li>
</ul>
</li>
</ul>

          </div>
        </div>
      </div>
      
      
    </aside>
  </div>
</div>
