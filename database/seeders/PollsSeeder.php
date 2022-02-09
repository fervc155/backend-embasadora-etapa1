<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poll;
class PollsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Poll::create([
            'name'=>'Encuesta de ubicacion',
            "version"=>"1",
            "questions"=>json_encode($this->questions),

        ]);
    }
 


 private $questions=array(
    "group_information" => array(
        "label" => "Informacion del cliente",
        "type" => "group",
        "content" => array(
            "name" => array(
                "label" => "Nombre completo",
                "type" => "text"
            ),
            "phone" => array(
                "label" => "Telefono",
                "type" => "text"
            ),
            "whatsapp" => array(
                "label" => "Whatsapp",
                "type" => "text"
            ),
            "email" => array(
                "label" => "Email",
                "type" => "text"
            ),
            "budget" => array(
                "label" => "Presupuesto aproximado de inversion",
                "type" => "number"
            ),
            "company" => array(
                "label" => "Empresa",
                "type" => "text"
            ),
            "antiquity" => array(
                "label" => "Antigüedad",
                "type" => "text"
            ),
            "facebook_company" => array(
                "label" => "Facebook de la empresa",
                "type" => "text"
            ),
            "instagram_company" => array(
                "label" => "Instagram de la empresa",
                "type" => "text"
            ),
            "products" => array(
                "label" => "Productos de interes",
                "type" => "textarea"
            ),
            "ingredients" => array(
                "label" => "Ingredientes",
                "type" => "textarea"
            )
        )
    ),
    "group_facebook" => array(
        "label" => "Facebook",
        "type" => "group",
        "content" => array(
            "facebook_antiquity" => array(
                "label" => "Antigüedad de la empresa en años",
                "type" => "radio",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "reputation" => array(
                "label" => "Reputacion",
                "type" => "radio",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "followers" => array(
                "label" => "Numero de seguidores",
                "type" => "radio",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "products_amount" => array(
                "label" => "Numero de productos",
                "type" => "radio",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "engagment" => array(
                "label" => "Engagment",
                "type" => "radio",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "imagen" => array(
                "label" => "Imagen",
                "type" => "radio",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "facebook_comments" => array(
                "label" => "Comentarios despues de revisar el facebook del cliente",
                "type" => "textarea"
            )
        )
    ),
    "group_instagram" => array(
        "label" => "instagram",
        "type" => "group",
        "content" => array(
            "reputation" => array(
                "label" => "Reputacion",
                "type" => "radio",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "followers" => array(
                "label" => "Numero de seguidores",
                "type" => "radio",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "products_amount" => array(
                "label" => "Numero de productos",
                "type" => "radio",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "engagment" => array(
                "label" => "Engagment",
                "type" => "radio",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "imagen" => array(
                "label" => "Imagen",
                "type" => "radio",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "first_post_antiquity" => array(
                "label" => "Antigüedad de la primera publicacion",
                "type" => "radio",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "instagram_comments" => array(
                "label" => "Comentarios despues de revisar el instagram del cliente",
                "type" => "textarea"
            )
        )
    ),
    "interest" => array(
        "label" => "¿Que desea?",
        "type" => "group",
        "content" => array(
            "wants_products" => array(
                "label" => "Producto",
                "type" => "check",
                "options" => array(
                    "0" => "Si",
                    "1" => "No",
                    "2" => "Talvez",
                    "3" => "ECONOMICA",
                    "4" => "PREMIUN"
                )
            ),
            "wants_label" => array(
                "label" => "Etiqueda",
                "type" => "check",
                "options" => array(
                    "0" => "Si",
                    "1" => "No",
                    "2" => "Talvez",
                    "3" => "ECONOMICA",
                    "4" => "PREMIUN"
                )
            ),
            "wants_labelled" => array(
                "label" => "Etiquedato",
                "type" => "check",
                "options" => array(
                    "0" => "Si",
                    "1" => "No",
                    "2" => "Talvez",
                    "3" => "ECONOMICA",
                    "4" => "PREMIUN"
                )
            ),
            "wants_container" => array(
                "label" => "Envase",
                "type" => "check",
                "options" => array(
                    "0" => "Si",
                    "1" => "No",
                    "2" => "Talvez",
                    "3" => "ECONOMICA",
                    "4" => "PREMIUN"
                )
            ),
            "wants_packing" => array(
                "label" => "Envasado",
                "type" => "check",
                "options" => array(
                    "0" => "Si",
                    "1" => "No",
                    "2" => "Talvez",
                    "3" => "ECONOMICA",
                    "4" => "PREMIUN"
                )
            ),
            "wants_sell_colombia" => array(
                "label" => "Vender en colombia",
                "type" => "check",
                "options" => array(
                    "0" => "Si",
                    "1" => "No",
                    "2" => "Talvez",
                    "3" => "ECONOMICA",
                    "4" => "PREMIUN"
                )
            ),
            "wants_sell_apps" => array(
                "label" => "Vender en apps tipo uber",
                "type" => "check",
                "options" => array(
                    "0" => "Si",
                    "1" => "No",
                    "2" => "Talvez",
                    "3" => "ECONOMICA",
                    "4" => "PREMIUN"
                )
            ),
            "interest_comments" => array(
                "label" => "Comentarios",
                "type" => "textarea"
            )
        )
    ),
    "services" => array(
        "label" => "¿Desea servicios?",
        "type" => "group",
        "content" => array(
            "wants_ads" => array(
                "label" => "Campañas en redes sociales",
                "type" => "check",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "wants_adworks" => array(
                "label" => "Campañas de google ads",
                "type" => "check",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "wants_design" => array(
                "label" => "Diseño publicitario",
                "type" => "check",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "wants_finder" => array(
                "label" => "Estudio de productos mas buscados en la red",
                "type" => "check",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "wants_lawyer" => array(
                "label" => "Asesoria juridica",
                "type" => "check",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "wants_financial" => array(
                "label" => "Asesoria financiera o contable",
                "type" => "check",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "wants_ecommerce" => array(
                "label" => "Asesoria para abrir tiendas en linea",
                "type" => "check",
                "options" => array(
                    "0" => 1,
                    "1" => 2,
                    "2" => 3,
                    "3" => 4,
                    "4" => 5
                )
            ),
            "services_comments" => array(
                "label" => "Comentarios",
                "type" => "textarea"
            )
        )
    ),
    "interest_data" => array(
        "label" => "Datos de interes",
        "type" => "group",
        "content" => array(
            "sells_amount" => array(
                "label" => "¿Cuántas piezas vende al mes?",
                "type" => "check",
                "options" => array(
                    "0" => "menos de 100",
                    "1" => "menos de 500",
                    "2" => "menos de 1000",
                    "3" => "mas de 1000"
                )
            ),
            "wants_amount" => array(
                "label" => "¿En cuantas piezas esta interesado?",
                "type" => "check",
                "options" => array(
                    "0" => "menos de 100",
                    "1" => "menos de 500",
                    "2" => "menos de 1000",
                    "3" => "mas de 1000"
                )
            ),
            "buy_last_month" => array(
                "label" => "¿Cuantas piezas compro el mes pasado?",
                "type" => "check",
                "options" => array(
                    "0" => "menos de 100",
                    "1" => "menos de 500",
                    "2" => "menos de 1000",
                    "3" => "mas de 1000"
                )
            ),
            "services_comments" => array(
                "label" => "Comentarios, solicitar información de a quien le compra y a que precio compra y ofrecer GARANTIA FORMULABS",
                "type" => "textarea"
            )
        )
    ),
    "extra" => array(
        "label" => "Informacion adicional",
        "type" => "group",
        "content" => array(
            "knows_before" => array(
                "label" => "¿Había leído o escuchado de FORMULABS antes?",
                "type" => "textarea"
            ),
            "competence" => array(
                "label" => "¿Ha comprado producto a alguna empresa de maquila? ¿ cuál? Y ¿Cuánto?",
                "type" => "textarea"
            ),
            "ideal_provider" => array(
                "label" => "¿Que busca para elegir proveedor?",
                "type" => "check",
                "options" => array(
                    "0" => "Renombre",
                    "1" => "Publicidad",
                    "2" => "Precio mas bajo",
                    "3" => "Rapidez",
                    "4" => "Asesoria virtual",
                    "5" => "Permisos",
                    "6" => "Apoyo para incrementar ventas"
                )
            ),
            "ideal_provider_comment" => array(
                "label" => "¿Otro? Especifique",
                "type" => "textarea"
            )
        )
    )
);

}