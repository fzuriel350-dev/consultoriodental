<?php

require __DIR__.'/../vendor/autoload.php';

use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\Font;

$outDir = __DIR__.'/../documentacion';

if (! is_dir($outDir)) {
    mkdir($outDir, 0777, true);
}

$teal = '0D9488';
$light = 'F0FDFA';
$dark = 'F1F5F9';

function styleWord(): PhpWord
{
    $word = new PhpWord;

    $word->addTitleStyle(1, ['size' => 22, 'bold' => true, 'color' => '0F766E', 'spaceAfter' => 120]);
    $word->addTitleStyle(2, ['size' => 15, 'bold' => true, 'color' => '155E75', 'spaceBefore' => 240, 'spaceAfter' => 120]);
    $word->addTitleStyle(3, ['size' => 12, 'bold' => true, 'color' => '0F172A', 'spaceBefore' => 160, 'spaceAfter' => 80]);
    $word->setDefaultFontName('Calibri');
    $word->setDefaultFontSize(11);

    return $word;
}

function addDataTable(Section $section, array $headers, array $rows, array $widths = [1, 4, 2, 2]): void
{
    $teal = '0D9488';
    $light = 'F0FDFA';

    $table = $section->addTable([
        'borderSize' => 6,
        'borderColor' => 'CBD5E1',
        'cellMargin' => 80,
        'alignment' => 'left',
    ]);

    $table->addRow();
    foreach ($headers as $i => $header) {
        $cell = $table->addCell($widths[$i] * 560);
        $cell->getStyle()->setShading(['fill' => $teal]);
        $cell->addText($header, ['bold' => true, 'color' => 'FFFFFF', 'size' => 10]);
    }

    foreach ($rows as $rowIndex => $row) {
        $table->addRow();
        foreach ($row as $i => $value) {
            $cell = $table->addCell($widths[$i] * 560);
            if ($rowIndex % 2 === 0) {
                $cell->getStyle()->setShading(['fill' => $light]);
            }
            $cell->addText((string) $value, ['size' => 10]);
        }
    }

    $section->addTextBreak(0.5);
}

$font = new Font;
$font->setName('Calibri');

/* ===================================================================== */
/* DOCUMENTO 1 — COTIZACIÓN */
/* ===================================================================== */

$word = styleWord();
$section = $word->addSection(['margin' => 720]);

$section->addTitle('Propuesta de Desarrollo — Sistema de Gestión de Citas y Sitio Web', 1);
$section->addTitle('Consultorio Dental — MVP (Producto Mínimo Viable)', 2);

$section->addText('Cliente: Dra. _____________ (Dentista)');
$section->addText('Proyecto: Sistema de agendamiento de citas + página web pública');
$section->addText('Fecha de emisión: _____________');
$section->addText('Validez de la propuesta: 30 días');
$section->addTextBreak();

$section->addTitle('1. Resumen ejecutivo', 2);
$section->addText(
    'Se propone el diseño y desarrollo de un MVP (Producto Mínimo Viable) que brinda al consultorio una página web pública '.
    'orientada a la captación de pacientes y un panel administrativo protegido para gestionar citas, pacientes, servicios, '.
    'horario de atención, testimonios y datos de contacto. El objetivo es digitalizar el proceso que hoy se lleva de forma '.
    'manual y otorgar presencia digital y publicidad orgánica al negocio.'
);
$section->addText('Plazo total: 8 semanas (2 meses). Modalidad: desarrollo por fases con entregables intermedios y aceptación del cliente.');

$section->addTitle('2. Alcance del proyecto', 2);
$section->addTitle('2.1 Incluido', 3);

addDataTable(
    $section,
    ['#', 'Entregable', 'Descripción'],
    [
        ['1', 'Landing page pública', 'Página web con secciones: portada, servicios, "acerca de mí", testimonios, contacto y llamada a la acción. SEO básico.'],
        ['2', 'Formulario de agendamiento rápido', 'El paciente solicita cita en línea: nombre, teléfono, correo (opcional), servicio, fecha y hora preferida.'],
        ['3', 'Panel administrativo', 'Acceso protegido (usuario y contraseña) exclusivo para la dentista.'],
        ['4', 'Gestión de citas', 'Ver, aceptar, rechazar, reprogramar y completar citas. Estados: pendiente, confirmada, completada, cancelada, rechazada.'],
        ['5', 'Gestión de pacientes', 'Registro de pacientes e historial de citas.'],
        ['6', 'Gestión de servicios', 'Catálogo editable: nombre, descripción, precio y duración.'],
        ['7', 'Horario de atención', 'Configuración de horarios por día de la semana.'],
        ['8', 'Testimonios', 'Publicación y activación/desactivación de testimonios.'],
        ['9', 'Configuración del sitio', 'Edición de nombre, contacto, dirección, redes y textos desde el panel.'],
        ['10', 'Base de datos', 'SQLite: estructura preparada para migrar a MySQL en el futuro.'],
        ['11', 'Capacitación', 'Sesión de capacitación y manual de uso básico.'],
    ],
    widths: [0.7, 3.5, 4]
);

$section->addTitle('2.2 Excluido (no incluido en esta propuesta)', 3);
foreach ([
    'Diseño de marca completo (logo, identidad visual) y fotografía profesional.',
    'Dominio y hospedaje (el costo se detalla en la sección 6).',
    'Notificaciones automáticas por SMS / WhatsApp / email a pacientes (post-MVP).',
    'Auto-agendado 100% autónomo sin confirmación humana.',
    'Historial clínico dental / expedientes clínicos digitales.',
    'Aplicaciones móviles nativas.',
    'Mantenimiento continuo post-lanzamiento (plan opcional).',
] as $item) {
    $section->addText(htmlspecialchars('• '.$item), ['size' => 10]);
}

$section->addTitle('3. Plan de trabajo por fases (8 semanas)', 2);
addDataTable(
    $section,
    ['Fase', 'Descripción', 'Semanas', 'Costo'],
    [
        ['1', 'Análisis, arquitectura y diseño', '1 – 2', '$350'],
        ['2', 'Desarrollo (landing, citas, panel admin)', '2 – 6', '$2,600'],
        ['3', 'Pruebas y control de calidad', '6 – 7', '$550'],
        ['4', 'Despliegue, capacitación y entrega', '7 – 8', '$400'],
        ['', 'TOTAL', '8 semanas', '$3,900 USD'],
    ],
    widths: [1, 4.5, 1.5, 1.5]
);

$section->addText(
    'Esfuerzo estimado: ~150 horas a una tarifa equivalente de USD $25–26/hora. '.
    'Los montos pueden expresarse en moneda local al tipo de cambio vigente.',
    ['italic' => true, 'size' => 9]
);
$section->addTextBreak();

$section->addTitle('Fase 1 — Análisis, arquitectura y diseño', 3);
foreach ([
    'Levantamiento de requerimientos y validación del alcance.',
    'Diagrama de flujo del paciente (solicitud → confirmación → atención).',
    'Modelo de datos y estructura de tablas (SQLite).',
    'Diseño de pantallas (landing + panel administrativo).',
    'Guía de contenidos y palabras clave para SEO básico.',
] as $item) {
    $section->addText(htmlspecialchars('• '.$item), ['size' => 10]);
}

$section->addTitle('Fase 2 — Desarrollo', 3);
foreach ([
    'Montaje del entorno, base de datos y autenticación del administrador.',
    'Landing page pública responsive con las secciones solicitadas.',
    'Formulario de solicitud de citas con validaciones.',
    'Módulo administrativo: citas, pacientes, servicios, disponibilidad, testimonios y configuración.',
    'Ajustes de SEO (metadatos, descripciones, estructura de URL).',
] as $item) {
    $section->addText(htmlspecialchars('• '.$item), ['size' => 10]);
}

$section->addTitle('Fase 3 — Pruebas y control de calidad', 3);
foreach ([
    'Pruebas funcionales del flujo completo de citas.',
    'Pruebas en móvil y navegadores principales (Chrome, Edge, Safari).',
    'Revisión de validaciones y seguridad básica.',
    'Corrección de errores y pulido final de interfaz.',
] as $item) {
    $section->addText(htmlspecialchars('• '.$item), ['size' => 10]);
}

$section->addTitle('Fase 4 — Despliegue y lanzamiento', 3);
foreach ([
    'Configuración de servidor, dominio y HTTPS.',
    'Publicación en producción y migración de datos.',
    'Configuración de copias de seguridad.',
    'Capacitación práctica a la dentista y entrega de manual.',
    'Entrega de documentación técnica y facturación.',
] as $item) {
    $section->addText(htmlspecialchars('• '.$item), ['size' => 10]);
}

$section->addTitle('4. Hitos y entregables intermedios', 2);
addDataTable(
    $section,
    ['Hito', 'Semana', 'Entregable'],
    [
        ['Kickoff', '1', 'Acta de inicio, cronograma y datos necesarios del cliente'],
        ['Diseño aprobado', '2', 'Maquetas/pantallas y modelo de datos aprobados'],
        ['Demo funcional', '5', 'Landing + solicitud de citas + panel básico en servidor de pruebas'],
        ['Versión Beta', '6', 'Módulos completos disponibles para revisión del cliente'],
        ['Certificación', '7', 'Resultado de pruebas; observaciones cerradas'],
        ['Entrega final', '8', 'Sitio en producción, capacitación y documentación'],
    ],
    widths: [2, 1.2, 5]
);

$section->addTitle('5. Condiciones de pago', 2);
addDataTable(
    $section,
    ['Concepto', 'Porcentaje', 'Momento'],
    [
        ['Anticipo (arranque)', '50%', 'Al firmar la propuesta y aprobar el alcance'],
        ['Avance (Versión Beta)', '30%', 'Al presentar la Beta funcional (semana 6)'],
        ['Entrega final', '20%', 'Al publicar en producción y capacitar (semana 8)'],
    ],
    widths: [3, 1.5, 4]
);

$section->addText('Los pagos se realizan por transferencia bancaria o el medio acordado.');
$section->addText('Se otorga 1 mes de garantía de correcciones (no nuevos desarrollos) a partir de la entrega final.');

$section->addTitle('6. Gastos aproximados a cargo del cliente (recomendados)', 2);
addDataTable(
    $section,
    ['Concepto', 'Estimado/año'],
    [
        ['Dominio (.com)', '$12 – $15'],
        ['Hospedaje web (PHP 8.x + SQLite/MySQL)', '$60 – $120'],
        ['Certificado SSL (incluido en la mayoría de planes)', '$0 – $20'],
    ],
    widths: [5, 2]
);

$section->addTitle('7. Supuestos y responsabilidades', 2);
foreach ([
    'El cliente aporta: textos definitivos, fotografías (si las desea usar), datos de contacto y acceso al panel para capacitación.',
    'El desarrollador entrega código funcional, documentado y con buenas prácticas de seguridad básica (hash de contraseñas, validaciones, protección CSRF).',
    'Cualquier cambio fuera del alcance se cotiza por separado mediante orden de cambio.',
    'El cronograma puede ajustarse si el cliente demora en entregar los insumos.',
] as $item) {
    $section->addText(htmlspecialchars('• '.$item), ['size' => 10]);
}

$section->addTitle('8. Aceptación', 2);
$section->addText('Declaro que he leído y aceptado las condiciones de esta propuesta.');
$section->addTextBreak();
$section->addText('Nombre: _________________________________');
$section->addText('Firma: __________________________________');
$section->addText('Fecha: __________________________________');

IOFactory::createWriter($word, 'Word2007')->save($outDir.'/Cotizacion_MVP_Dentista.docx');

/* ===================================================================== */
/* DOCUMENTO 2 — WBS / EDT */
/* ===================================================================== */

$word = styleWord();
$section = $word->addSection(['margin' => 720]);

$section->addTitle('WBS / EDT — Proyecto: Sistema de Gestión de Citas y Sitio Web', 1);
$section->addTitle('Consultorio Dental — MVP · Duración: 8 semanas (2 meses)', 2);

function wbsBlock(Section $section, string $title, array $rows): void
{
    $section->addTitle($title, 2);
    addDataTable(
        $section,
        ['Código', 'Paquete de trabajo', 'Semana'],
        $rows,
        widths: [1.2, 6, 1.3]
    );
}

wbsBlock($section, '1. Gestión del Proyecto (Semanas 1–8)', [
    ['1.1', 'Reunión de arranque (kickoff) y levantamiento de requerimientos', '1'],
    ['1.2', 'Cronograma, plan de comunicaciones y criterios de aceptación', '1'],
    ['1.3', 'Seguimiento semanal y reportes de avance', '2–7'],
    ['1.4', 'Gestión de cambios, riesgos y decisiones', '1–8'],
    ['1.5', 'Reunión de cierre, acta de entrega y facturación', '8'],
]);

wbsBlock($section, '2. Análisis y Diseño (Semanas 1–2)', [
    ['2.1', 'Mapa del sitio y flujo del paciente (solicitud → confirmación → atención)', '1'],
    ['2.2', 'Modelo de datos: entidades, campos y relaciones (SQLite)', '2'],
    ['2.3', 'Prototipo de pantallas: landing, formulario de cita, panel administrativo', '2'],
    ['2.4', 'Contenidos de la página y palabras clave para SEO básico', '2'],
]);

wbsBlock($section, '3. Desarrollo (Semanas 2–6)', [
    ['3.1', 'Configuración del entorno, repositorio y base de código inicial', '2'],
    ['3.2', 'Implementación de migraciones y modelo de datos', '2'],
    ['3.3', 'Autenticación del administrador (login protegido)', '2–3'],
    ['3.4', 'Landing page pública (portada, servicios, acerca de, testimonios, contacto)', '3–4'],
    ['3.5', 'Formulario de solicitud de citas con validaciones', '3'],
    ['3.6', 'Módulo de citas (listar, aceptar, rechazar, reprogramar, completar)', '4–5'],
    ['3.7', 'Módulo de pacientes e historial', '4'],
    ['3.8', 'Módulo de servicios y catálogo editable', '4–5'],
    ['3.9', 'Módulo de disponibilidad (horarios por día)', '4–5'],
    ['3.10', 'Módulo de testimonios y publicaciones', '5'],
    ['3.11', 'Módulo de configuración del sitio', '5'],
    ['3.12', 'SEO básico: metadatos, descripciones y estructura de URLs', '6'],
]);

wbsBlock($section, '4. Pruebas y Calidad (Semanas 6–7)', [
    ['4.1', 'Pruebas funcionales del flujo completo de citas', '6'],
    ['4.2', 'Pruebas del panel administrativo (estados, configuraciones)', '6'],
    ['4.3', 'Pruebas de seguridad: validaciones, autenticación y protección CSRF', '7'],
    ['4.4', 'Pruebas multiplataforma: móvil, tablet y navegadores principales', '7'],
    ['4.5', 'Corrección de errores, pulido y certificación de la versión Beta', '7'],
]);

wbsBlock($section, '5. Despliegue y Lanzamiento (Semanas 7–8)', [
    ['5.1', 'Preparación del servidor, dominio y certificado SSL (HTTPS)', '7'],
    ['5.2', 'Publicación en producción y migración de datos finales', '8'],
    ['5.3', 'Configuración de copias de seguridad y monitoreo básico', '8'],
    ['5.4', 'Capacitación práctica a la dentista y manual de uso', '8'],
    ['5.5', 'Documentación técnica, acta de entrega y cierre', '8'],
]);

$section->addTitle('Hitos del proyecto', 2);
addDataTable(
    $section,
    ['Hito', 'Semana', 'Criterio de éxito'],
    [
        ['Kickoff', '1', 'Requerimientos validados y cronograma firmado'],
        ['Diseño aprobado', '2', 'Prototipos y modelo de datos aprobados'],
        ['Demo funcional', '5', 'Landing + cita + panel funcionando en pruebas'],
        ['Versión Beta', '6', 'Todos los módulos disponibles para revisión'],
        ['Certificación', '7', 'Pruebas cerradas sin errores bloqueantes'],
        ['Entrega', '8', 'Sitio en producción; capacitación y documentos entregados'],
    ],
    widths: [2.2, 1.2, 5]
);

$section->addTitle('Responsabilidades', 2);
addDataTable(
    $section,
    ['Rol', 'Responsabilidad'],
    [
        ['Desarrollador', 'Arquitectura, desarrollo, pruebas, despliegue, capacitación'],
        ['Cliente (dentista)', 'Textos, datos, fotos, decisiones de contenido, aceptación de hitos'],
        ['Ambos', 'Reuniones semanales, revisión de demos y retroalimentación'],
    ],
    widths: [3, 5.5]
);

$section->addTitle('Definición de "listo" (Definition of Done)', 2);
foreach ([
    'El flujo público (solicitar cita) funciona de extremo a extremo.',
    'El panel permite gestionar citas, pacientes, servicios, disponibilidad, testimonios y configuración.',
    'La autenticación protege todas las rutas administrativas.',
    'El sitio es responsive (móvil, tablet, escritorio).',
    'SEO básico aplicado (metadatos y descripción).',
    'Pruebas automatizadas del flujo principal en verde.',
    'Copia de seguridad configurada en producción.',
    'Capacitación realizada y documentación entregada.',
] as $item) {
    $section->addText(htmlspecialchars('☐ '.$item), ['size' => 10]);
}

$section->addTitle('Backlog sugerido post-MVP (fase 2)', 2);
foreach ([
    'Notificaciones automáticas por WhatsApp/email al confirmar o reprogramar citas.',
    'Recordatorios de cita 24 horas antes.',
    'Auto-agendado en franjas libres según disponibilidad.',
    'Historial clínico digital y expedientes por paciente.',
    'Múltiples usuarios administrativos (asistentes).',
    'Migración de SQLite a MySQL al crecer.',
    'Reportes de ingresos por servicio y período.',
] as $item) {
    $section->addText(htmlspecialchars('• '.$item), ['size' => 10]);
}

IOFactory::createWriter($word, 'Word2007')->save($outDir.'/EDT_WBS_MVP_Dentista.docx');

echo "Documentos generados:\n";
echo "  - {$outDir}/Cotizacion_MVP_Dentista.docx\n";
echo "  - {$outDir}/EDT_WBS_MVP_Dentista.docx\n";
