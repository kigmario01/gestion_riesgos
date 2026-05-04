<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmenazasSeeder extends Seeder
{
    public function run(): void
    {
        $amenazas = [
            [
                'codigo' => 'A1',
                'nombre' => 'Fuego',
                'categoria' => 'ambiental',
                'origen' => 'externo',
                'descripcion' => 'Aquí podríamos distinguir sobre fuego en CPD (centro proceso de datos) o en oficinas etc.',
            ],
            [
                'codigo' => 'A2',
                'nombre' => 'Condiciones climáticas desfavorables',
                'categoria' => 'ambiental',
                'origen' => 'externo',
                'descripcion' => 'Se trata de analizar las consecuencias para equipos e instalaciones en caso de condiciones adversas. Como ejemplo podríamos evaluar las consecuencias de las altas temperaturas en verano junto con las necesidades de los equipos de climatización. En este caso deberíamos evaluar fallos en equipos por altas temperaturas o desmagnetizaciones de soportes de información etc.',
            ],
            [
                'codigo' => 'A3',
                'nombre' => 'Inundaciones',
                'categoria' => 'ambiental',
                'origen' => 'externo',
                'descripcion' => 'Aquí deberíamos evaluar las posibles causas de inundaciones de agua en las instalaciones y oficinas: interrupciones de suministro, sistemas de riego, sistemas de calefacción, sistemas contra incendios, sabotajes (grifos, bloqueo de desagües etc.).',
            ],
            [
                'codigo' => 'A4',
                'nombre' => 'Contaminación, polvo, corrosión',
                'categoria' => 'ambiental',
                'origen' => 'interno',
                'descripcion' => 'En este punto podríamos tener en cuenta el riesgo de contaminación de salas de equipos especialmente sensibles a niveles de polvo o sustancias en suspensión etc. Contaminación por obras o reformas en las salas, polvo derivado de tareas de empaquetado, instalaciones de nuevos equipos.',
            ],
            [
                'codigo' => 'A5',
                'nombre' => 'Desastres Naturales',
                'categoria' => 'ambiental',
                'origen' => 'natural',
                'descripcion' => 'Probabilidad de ser afectado por inundaciones, terremotos, tormentas eléctricas, impactos sobre la disponibilidad de servicios de comunicaciones etc.',
            ],
            [
                'codigo' => 'A6',
                'nombre' => 'Desastres ambientales',
                'categoria' => 'ambiental',
                'origen' => 'externo',
                'descripcion' => 'Probabilidad de ser afectado por desastres ambientales: incendios, explosiones, fugas, evaluación del entorno (empresas vecinas con actividades peligrosas), interrupción de accesos al trabajo.',
            ],
            [
                'codigo' => 'A7',
                'nombre' => 'Eventos importantes en el medio ambiente',
                'categoria' => 'ambiental',
                'origen' => 'externo',
                'descripcion' => 'Probabilidad de ser afectado por obras realizadas en el entorno, manifestaciones o desordenes públicos etc.',
            ],
            [
                'codigo' => 'A8',
                'nombre' => 'Interrupción de la fuente de alimentación',
                'categoria' => 'tecnica',
                'origen' => 'externo',
                'descripcion' => 'Probabilidad de interrupciones y micro cortes en el suministro eléctrico, estabilidad de la red, subidas de tensión, afectaciones a sistemas de seguridad y ascensores, interrupciones prolongadas.',
            ],
            [
                'codigo' => 'A9',
                'nombre' => 'Interrupción de las redes de comunicación',
                'categoria' => 'tecnica',
                'origen' => 'externo',
                'descripcion' => 'Cómo afectan las interrupciones de las comunicaciones a: comunicación con los clientes, procesos propios del negocio, pérdidas de datos, procesos de pedidos, dependencia de servicios de Internet, etc.',
            ],
            [
                'codigo' => 'A10',
                'nombre' => 'Interrupción del suministro de red',
                'categoria' => 'tecnica',
                'origen' => 'externo',
                'descripcion' => 'Sistemas o tareas afectadas por falta de suministro: climatización o ventilación, agua y alcantarillado (sistema contra incendios), gas, sistemas de alarma y control (robo, incendio, control de limpieza), sistemas de comunicación internos.',
            ],
            [
                'codigo' => 'A11',
                'nombre' => 'Fracaso o interrupción de los proveedores de servicios',
                'categoria' => 'tecnica',
                'origen' => 'externo',
                'descripcion' => 'Interrupciones parciales o totales de servicios subcontratados, niveles de calidad de los servicios no aceptables, indisponibilidad de instalaciones externas.',
            ],
            [
                'codigo' => 'A12',
                'nombre' => 'Interferencias',
                'categoria' => 'tecnica',
                'origen' => 'externo',
                'descripcion' => 'Interferencias en servicios inalámbricos (p. ej. Redes WLAN, Bluetooth, GSM, UMTS).',
            ],
            [
                'codigo' => 'A13',
                'nombre' => 'Emisiones comprometidas',
                'categoria' => 'tecnica',
                'origen' => 'interno',
                'descripcion' => 'Riesgo de interceptación de información confidencial por radiaciones emitidas por equipos.',
            ],
            [
                'codigo' => 'A14',
                'nombre' => 'Espionaje',
                'categoria' => 'deliberada',
                'origen' => 'externo',
                'descripcion' => 'Riesgo de exposición de información sobre la compañía, productos y servicios que puedan ser utilizados por la competencia o entidades para perjuicio de la actividad de la organización: escuchas ilegales, intercepción de señales de transmisión, intercepción de transmisiones desprotegidas de datos en redes públicas.',
            ],
            [
                'codigo' => 'A15',
                'nombre' => 'Robo de dispositivos, soportes de almacenamiento y documentos',
                'categoria' => 'deliberada',
                'origen' => 'externo',
                'descripcion' => 'Robo de soportes de almacenamiento de datos, sistemas de TI, accesorios, software o datos de clientes etc.',
            ],
            [
                'codigo' => 'A16',
                'nombre' => 'Pérdida de dispositivos, soportes de almacenamiento y documentos',
                'categoria' => 'accidental',
                'origen' => 'interno',
                'descripcion' => 'Pérdidas de equipos portátiles o soportes de almacenamiento de datos (tarjetas de memoria), documentos impresos olvidados en restaurantes o en lugares públicos, medios de transporte.',
            ],
            [
                'codigo' => 'A17',
                'nombre' => 'Mala planificación o falta de adaptación',
                'categoria' => 'accidental',
                'origen' => 'interno',
                'descripcion' => 'Procedimientos inadecuados de mantenimiento, protocolos de transferencia, procesos de adquisición de nuevas tecnologías.',
            ],
            [
                'codigo' => 'A18',
                'nombre' => 'Información o productos de una fuente no confiable',
                'categoria' => 'accidental',
                'origen' => 'externo',
                'descripcion' => 'Verificación insuficiente de información o software externo, apertura de archivos o aplicaciones provenientes de fuentes no verificadas en equipos de trabajo (p. ej. emails), instalación de aplicaciones y actualizaciones de software por usuarios finales.',
            ],
            [
                'codigo' => 'A19',
                'nombre' => 'Divulgación de información sensible',
                'categoria' => 'deliberada',
                'origen' => 'interno',
                'descripcion' => 'Accesos no autorizados, reciclaje de equipos y soportes, destrucción de equipos y soportes, software malicioso, difusión de información inadvertida en procesos externos (órdenes de reparación etc.), robo de contraseñas, etc.',
            ],
            [
                'codigo' => 'A20',
                'nombre' => 'Manipulación de información',
                'categoria' => 'deliberada',
                'origen' => 'interno',
                'descripcion' => 'Datos falsos en formato electrónico o en papel, falsificación o modificación de datos y documentos.',
            ],
            [
                'codigo' => 'A21',
                'nombre' => 'Acceso no autorizado a los sistemas de TI',
                'categoria' => 'deliberada',
                'origen' => 'externo',
                'descripcion' => 'Accesos no autorizados a aplicaciones o sistemas.',
            ],
            [
                'codigo' => 'A22',
                'nombre' => 'Destrucción de dispositivos o soportes de almacenamiento',
                'categoria' => 'deliberada',
                'origen' => 'interno',
                'descripcion' => 'Destrucción de soportes de almacenamiento o sistemas TI por venganzas, negligencias o usos indebidos.',
            ],
            [
                'codigo' => 'A23',
                'nombre' => 'Fallo de dispositivos o sistemas',
                'categoria' => 'tecnica',
                'origen' => 'interno',
                'descripcion' => 'Fallos en dispositivos críticos del sistema, fallos técnicos por mal funcionamiento, fallos por uso indebido o errores humanos, fallos por causas externas (falta de suministro etc.), fallos por sabotaje, fallos por accidentes.',
            ],
            [
                'codigo' => 'A24',
                'nombre' => 'Mal funcionamiento de dispositivos o sistemas',
                'categoria' => 'tecnica',
                'origen' => 'interno',
                'descripcion' => 'Por fatiga o desgaste del material, falta de mantenimiento, tolerancias de fabricación, errores de diseño, superación de límites máximos de carga o condiciones de uso.',
            ],
            [
                'codigo' => 'A25',
                'nombre' => 'Falta de recursos',
                'categoria' => 'tecnica',
                'origen' => 'interno',
                'descripcion' => 'Congestiones en el servicio (cuellos de botella), sobrecargas en sistemas e infraestructuras, requisitos de nuevas aplicaciones que exceden las capacidades existentes, falta de recursos económicos.',
            ],
            [
                'codigo' => 'A26',
                'nombre' => 'Vulnerabilidades o errores del software',
                'categoria' => 'tecnica',
                'origen' => 'interno',
                'descripcion' => 'Errores de programación, fallos en navegadores y aplicaciones WEB.',
            ],
            [
                'codigo' => 'A27',
                'nombre' => 'Violación de leyes o regulaciones',
                'categoria' => 'deliberada',
                'origen' => 'interno',
                'descripcion' => 'Violaciones de leyes sobre procesamientos de información, incumplimientos de cláusulas contractuales, incumplimientos legales en el tratamiento de datos personales.',
            ],
            [
                'codigo' => 'A28',
                'nombre' => 'Uso no autorizado o administración de dispositivos y sistemas',
                'categoria' => 'deliberada',
                'origen' => 'interno',
                'descripcion' => 'Uso no autorizado o administración indebida de dispositivos y sistemas de información.',
            ],
            [
                'codigo' => 'A29',
                'nombre' => 'Uso incorrecto o administración de dispositivos y sistemas',
                'categoria' => 'accidental',
                'origen' => 'interno',
                'descripcion' => 'Uso incorrecto o administración inadecuada de dispositivos y sistemas de información.',
            ],
            [
                'codigo' => 'A30',
                'nombre' => 'Abuso de Autorizaciones',
                'categoria' => 'deliberada',
                'origen' => 'interno',
                'descripcion' => 'Abuso de privilegios y autorizaciones otorgadas a usuarios o administradores.',
            ],
            [
                'codigo' => 'A31',
                'nombre' => 'Ausencia de personal',
                'categoria' => 'accidental',
                'origen' => 'interno',
                'descripcion' => 'Bajas prolongadas, sustituciones por bajas o vacaciones, bajas masivas por epidemias.',
            ],
            [
                'codigo' => 'A32',
                'nombre' => 'Terrorismo',
                'categoria' => 'deliberada',
                'origen' => 'externo',
                'descripcion' => 'Ataques con explosivos, incendios premeditados, ataques con armas de fuego.',
            ],
            [
                'codigo' => 'A33',
                'nombre' => 'Coerción, extorsión o corrupción',
                'categoria' => 'deliberada',
                'origen' => 'externo',
                'descripcion' => 'Uso indebido de datos o acceso a datos confidenciales por chantajes, extorsiones o corrupción de personas.',
            ],
            [
                'codigo' => 'A34',
                'nombre' => 'Robo de identidad',
                'categoria' => 'deliberada',
                'origen' => 'externo',
                'descripcion' => 'Robos de datos personales para suplantar identidades (datos bancarios etc.), ataques con datos ficticios (suplantación de identidades por máquinas o robots).',
            ],
            [
                'codigo' => 'A35',
                'nombre' => 'Comportamientos anti-éticos',
                'categoria' => 'deliberada',
                'origen' => 'interno',
                'descripcion' => 'Negación de recepción de informaciones, mensajes o instrucciones de seguridad (p. ej. negar la recepción de emails o pedidos realizados etc.).',
            ],
            [
                'codigo' => 'A36',
                'nombre' => 'Abuso de datos personales',
                'categoria' => 'deliberada',
                'origen' => 'interno',
                'descripcion' => 'Violaciones a las leyes sobre protección de datos: recoger datos sin base legal o consentimiento, uso para fines diferentes al objetivo establecido en el momento de la recolección, eliminación de datos personales demasiado tarde, divulgación de datos de forma no autorizada, etc.',
            ],
            [
                'codigo' => 'A37',
                'nombre' => 'Software malicioso',
                'categoria' => 'deliberada',
                'origen' => 'externo',
                'descripcion' => 'Ataques de software malicioso tales como virus, gusanos y caballos de Troya.',
            ],
            [
                'codigo' => 'A38',
                'nombre' => 'Ataques DoS o denegación de servicio',
                'categoria' => 'deliberada',
                'origen' => 'externo',
                'descripcion' => 'Interrupciones de los procesos comerciales (envío masivo de formularios etc.), daños a la infraestructura (bloqueo de accesos etc.), fallos por sobrecarga por ataques por accesos masivos provocados.',
            ],
            [
                'codigo' => 'A39',
                'nombre' => 'Ingeniería Social',
                'categoria' => 'deliberada',
                'origen' => 'externo',
                'descripcion' => 'Los ataques típicos de ingeniería social para acceder de forma no autorizada suponen casi siempre una suplantación de identidad basándose en la confianza, miedo o respeto de personas. Normalmente se utilizan llamadas urgentes para reclamar información de contraseñas etc. amparados en la autoridad, la amistad o la confianza.',
            ],
            [
                'codigo' => 'A41',
                'nombre' => 'Reproducción de mensajes',
                'categoria' => 'deliberada',
                'origen' => 'externo',
                'descripcion' => 'Intercepción de transmisiones para introducir datos maliciosos y retransmitir el mensaje.',
            ],
            [
                'codigo' => 'A42',
                'nombre' => 'Entrada no autorizada a las instalaciones',
                'categoria' => 'deliberada',
                'origen' => 'externo',
                'descripcion' => 'Acceso físico no autorizado a las instalaciones de la organización.',
            ],
            [
                'codigo' => 'A43',
                'nombre' => 'Pérdida de datos',
                'categoria' => 'accidental',
                'origen' => 'interno',
                'descripcion' => 'Pérdida de la disponibilidad de datos por borrados indebidos o corrupción por software malicioso, usos indebidos o fallos técnicos.',
            ],
        ];

        foreach ($amenazas as $amenaza) {
            DB::table('amenazas')->updateOrInsert(
                ['codigo' => $amenaza['codigo']],
                array_merge($amenaza, [
                    'estado' => 'activa',
                    'registrado_por' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
