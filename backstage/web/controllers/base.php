<?php

/*
 * This file is part of the CRUD Admin Generator project.
 *
 * Author: Jon Segador <jonseg@gmail.com>
 * Web: http://crud-admin-generator.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/../../src/app.php';


require_once __DIR__.'/actividad/index.php';
require_once __DIR__.'/archivo/index.php';
require_once __DIR__.'/area/index.php';
require_once __DIR__.'/banner/index.php';
require_once __DIR__.'/beca/index.php';
require_once __DIR__.'/cargo/index.php';
require_once __DIR__.'/categoria_formulario/index.php';
require_once __DIR__.'/categoria_guia_judicial/index.php';
require_once __DIR__.'/contenido/index.php';
require_once __DIR__.'/contenido_agregado/index.php';
require_once __DIR__.'/curso/index.php';
require_once __DIR__.'/curso_destinatario/index.php';
require_once __DIR__.'/curso_dirigido/index.php';
require_once __DIR__.'/curso_docente/index.php';
require_once __DIR__.'/curso_lugar/index.php';
require_once __DIR__.'/curso_usuario_sitio/index.php';
require_once __DIR__.'/dependencia/index.php';
require_once __DIR__.'/dependencia_fueros/index.php';
require_once __DIR__.'/destinatario/index.php';
require_once __DIR__.'/docente/index.php';
require_once __DIR__.'/estado_beca/index.php';
require_once __DIR__.'/estado_curso/index.php';
require_once __DIR__.'/facultad/index.php';
require_once __DIR__.'/formulario/index.php';
require_once __DIR__.'/fuero/index.php';
require_once __DIR__.'/galeria/index.php';
require_once __DIR__.'/grupo_curso/index.php';
require_once __DIR__.'/grupo_curso2/index.php';
require_once __DIR__.'/grupo_curso3/index.php';
require_once __DIR__.'/grupo_novedad/index.php';
require_once __DIR__.'/guia_judicial/index.php';
require_once __DIR__.'/helper/index.php';
require_once __DIR__.'/instituto/index.php';
require_once __DIR__.'/link/index.php';
require_once __DIR__.'/lugar/index.php';
require_once __DIR__.'/modulo/index.php';
require_once __DIR__.'/multimedia/index.php';
require_once __DIR__.'/multimedia_sesion/index.php';
require_once __DIR__.'/novedad/index.php';
require_once __DIR__.'/novedad_foto/index.php';
require_once __DIR__.'/perfil/index.php';
require_once __DIR__.'/subgrupo_curso/index.php';
require_once __DIR__.'/tema/index.php';
require_once __DIR__.'/tematica/index.php';
require_once __DIR__.'/tipo_actividad/index.php';
require_once __DIR__.'/tipo_banner/index.php';
require_once __DIR__.'/tipo_certificado/index.php';
require_once __DIR__.'/tipo_condicion/index.php';
require_once __DIR__.'/tipo_curso/index.php';
require_once __DIR__.'/tipo_instituto/index.php';
require_once __DIR__.'/tipo_target/index.php';
require_once __DIR__.'/titulo/index.php';
require_once __DIR__.'/universidad/index.php';
require_once __DIR__.'/universidad_sigla/index.php';
require_once __DIR__.'/users/index.php';
require_once __DIR__.'/usuario/index.php';
require_once __DIR__.'/usuario_sitio/index.php';
require_once __DIR__.'/video1/index.php';
require_once __DIR__.'/video2/index.php';



$app->match('/', function () use ($app) {

    return $app['twig']->render('ag_dashboard.html.twig', array());
        
})
->bind('dashboard');


$app->run();