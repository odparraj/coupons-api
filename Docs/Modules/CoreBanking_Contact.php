<?php

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Contact - Admin API",
 *      description="API permitido para los clientes",
 *      @OA\Contact(
 *          email="system@zinobe.com"
 *      )
 * )
 */

/**
 *  @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Servidor por defecto"
 *  )
 */

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Autenticación de los clientes",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://zinobe.com"
 *     )
 * ),
 * 
 */

/**
 * @OA\Post(
 *      path="contact/auth/login",
 *      tags={"Auth"},
 *      summary="Autentica al cliente",
 *      description="Retorna un token de autenticación",
 *
 * @OA\RequestBody(
 *     request="UserArray",
 *     description="Autentica al usuario",
 *     required=true,
 *    @OA\JsonContent(
 *       type="object",
 *       required={"email", "password"},
 *       @OA\Property(
 *         property="email",
 *         type="string",
 *         example="contact@aliatu.com",
 *         description="El email del contacto registrado"
 *       ),
 *      @OA\Property(
 *         property="password",
 *         type="string",
 *         example="1234567",
 *         description="Contraseña"
 *       )
 *    )
 * ),
 * 
 * @OA\Response(
 *     response=200,
 *     description="Cliente autenticado.",
 *     @OA\JsonContent(
 *       type="object",
 *       @OA\Property(
 *         property="success",
 *         type="boolean",
 *         format="boolean",
 *         description="Si hubo error",
 *       ),
 *      @OA\Property(
 *         property="code",
 *         type="integer",
 *         format="int32",
 *         description="Código del error"
 *       ),
 *      @OA\Property(
 *         property="locale",
 *         type="string",
 *         format="string",
 *         description="Lenguaje del mensaje"
 *       ),
 *      @OA\Property(
 *         property="message",
 *         type="string",
 *         format="string",
 *         description="Mensaje de la respuesta"
 *       ),
 *       @OA\Property(
 *         property="data",
 *         type="object",
 *         format="object",
 *         description="Datos de retorno",
 *          type="object",
 *       @OA\Property(
 *         property="name",
 *         type="string",
 *         format="string",
 *         example="System Zinobe",
 *         description="Nombre del usuario"
 *       ),
 *       @OA\Property(
 *         property="email",
 *         type="string",
 *         example="system3@zinobe.com",
 *         description="Correo del usuario"
 *       ),
 *      @OA\Property(
 *         property="genre",
 *         type="string",
 *         example="M",
 *         description="Género del cliente"
 *       ),
 *      @OA\Property(
 *         property="token",
 *         type="string",
 *         example="hcoKUrhMXZOQW9uKidMId1GvPFbt5m6CDL97cbqVtUkwPRehrd4YoUIJTTBI",
 *         description="Token de acceso"
 *       )
 *      )
 *     )
 * ),
 * @OA\Response(
 *     response=400,
 *     description="Credenciales inválidas",
 *     @OA\JsonContent(
 *       type="object",
 *       @OA\Property(
 *         property="success",
 *         type="boolean",
 *         format="boolean",
 *         description="Si hubo error",
 *          example="false"
 *       ),
 *      @OA\Property(
 *         property="code",
 *         type="integer",
 *         format="int32",
 *         description="Código del error",
 *         example="100"
 *       ),
 *      @OA\Property(
 *         property="locale",
 *         type="string",
 *         format="string",
 *         description="Lenguaje del mensaje",
 *         example="en"
 *       ),
 *      @OA\Property(
 *         property="message",
 *         type="string",
 *         format="string",
 *         description="Mensaje de la respuesta",
 *          example="api.auth_invalid_credentials"
 *       ),
 *       @OA\Property(
 *         property="data",
 *         type="object",
 *         format="object",
 *         description="Datos de retorno",
 *          type="object",
 *          example=null
 *      )
 *     )
 * ),
 * 
 * )
 */

//Route::post('auth/login', 'Contacts\ContactsController@login');

/**
* @OA\Get(
*      path="contact/auth/register",
*      tags={"Auth"},
*      summary="Registro del cliente",
*      description="Registra a un cliente en el sistema",
* 
* @OA\RequestBody(
*     description="Autentica al usuario",
*     required=true,
*    @OA\JsonContent(
*       type="object",
*       required={"email","password", "source_id"},
*      @OA\Property(
*         property="email",
*         type="string",
*         example="nombre@dominio.com",
*         description="Correo electrónico"
*       ),
*      @OA\Property(
*         property="password",
*         type="string",
*         example="1234567",
*         description="Contraseña"
*       ),
*       @OA\Property(
*         property="source_id",
*         type="uuid",
*         example="c236259d-d844-4f2b-85d9-d8fad5b11b95",
*         description="La fuente por la cual llega el contacto"
*       )
*    )
* 
* ),
* 
 * @OA\Response(
 *     response=200,
 *     description="Cliente registrado con éxito",
 *     @OA\JsonContent(
 *       type="object",
 *       @OA\Property(
 *         property="success",
 *         type="boolean",
 *         format="boolean",
 *         example="true",
 *         description="Si hubo error",
 *       ),
 *      @OA\Property(
 *         property="code",
 *         type="integer",
 *         format="int32",
 *         example="0",
 *         description="Código del error"
 *       ),
 *      @OA\Property(
 *         property="locale",
 *         type="string",
 *         format="string",
 *         example="en",
 *         description="Lenguaje del mensaje"
 *       ),
 *      @OA\Property(
 *         property="message",
 *         type="string",
 *         format="string",
 *         example="OK",
 *         description="Mensaje de la respuesta"
 *       ),
 *       @OA\Property(
 *         property="data",
 *         type="object",
 *         format="object",
 *         description="Datos de retorno",
 *         type="object",
 *       
 *       @OA\Property(
 *         property="id",
 *         type="uuid",
 *         format="uuid",
 *         example="3c1890b7-b28b-4ffd-8a1e-d237bb58289c",
 *         description="Id del usuario"
 *       ),
 *      )
 *     )
 * ),
 * @OA\Response(
 *     response=400,
 *     description="Error de validación",
 *     @OA\JsonContent(
 *       type="object",
 *       @OA\Property(
 *         property="success",
 *         type="boolean",
 *         format="boolean",
 *         description="Si hubo error",
 *          example="false"
 *       ),
 *      @OA\Property(
 *         property="code",
 *         type="integer",
 *         format="int32",
 *         description="Código del error",
 *         example="13"
 *       ),
 *      @OA\Property(
 *         property="locale",
 *         type="string",
 *         format="string",
 *         description="Lenguaje del mensaje",
 *         example="en"
 *       ),
 *      @OA\Property(
 *         property="message",
 *         type="string",
 *         format="string",
 *         description="Mensaje de la respuesta",
 *         example="The given data was invalid."
 *       ),
 *       @OA\Property(
 *         property="data",
 *         type="object",
 *         format="object",
 *         description="Datos de retorno",
 *          type="object",
 *      )
 *     )
 * ),
* 
*)
*
*/


/**
 * @OA\Tag(
 *     name="Source",
 *     description="La fuente por la cual llega el contacto",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://zinobe.com"
 *     )
 * ),
 *

//Route::post('auth/login', 'Contacts\ContactsController@login');

/**
* @OA\Get(
*      path="sources",
*      tags={"Source"},
*      summary="Listado de fuentes",
*      description="Lista todas las fuentes registradas",
*
*
 * @OA\Response(
 *     response=200,
 *     description="OK",
 *     @OA\JsonContent(
 *       type="object",
 *       @OA\Property(
 *         property="success",
 *         type="boolean",
 *         format="boolean",
 *         example="true",
 *         description="Si hubo error",
 *       ),
 *      @OA\Property(
 *         property="code",
 *         type="integer",
 *         format="int32",
 *         example="0",
 *         description="Código del error"
 *       ),
 *      @OA\Property(
 *         property="locale",
 *         type="string",
 *         format="string",
 *         example="en",
 *         description="Lenguaje del mensaje"
 *       ),
 *      @OA\Property(
 *         property="message",
 *         type="string",
 *         format="string",
 *         example="OK",
 *         description="Mensaje de la respuesta"
 *       ),
 *       @OA\Property(
 *         property="data",
 *         type="array",
 *         format="array",
 *         description="Datos de retorno",
 *         @OA\Items(ref="#/components/schemas/Source")
 *      )
 *      )
 *     )
 * ),
 * @OA\Response(
 *     response=400,
 *     description="Error de validación",
 *     @OA\JsonContent(
 *       type="object",
 *       @OA\Property(
 *         property="success",
 *         type="boolean",
 *         format="boolean",
 *         description="Si hubo error",
 *          example="false"
 *       ),
 *      @OA\Property(
 *         property="code",
 *         type="integer",
 *         format="int32",
 *         description="Código del error",
 *         example="13"
 *       ),
 *      @OA\Property(
 *         property="locale",
 *         type="string",
 *         format="string",
 *         description="Lenguaje del mensaje",
 *         example="en"
 *       ),
 *      @OA\Property(
 *         property="message",
 *         type="string",
 *         format="string",
 *         description="Mensaje de la respuesta",
 *         example="The given data was invalid."
 *       ),
 *       @OA\Property(
 *         property="data",
 *         type="object",
 *         format="object",
 *         description="Datos de retorno",
 *          type="object",
 *      )
 *     )
 * ),
*
*)
*
*/


//Route::post('/source', 'Contacts\ContactsController@register');

//Falta por documentar
//Route::get('auth/logout', 'Contacts\ContactsController@logout')->middleware('auth:api_contact');

//Route::get('home/{product_config_id}/form', 'Contacts\ContactsController@homeProductConfigForm'); //Muestra la estructura de la data del producto que puede editar el cliente


/**
 * @OA\Tag(
 *     name="Home",
 *     description="Servicios abiertos desde el Home",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://zinobe.com"
 *     )
 * ),
 * 
 */

/**
* @OA\Get(
*      path="contact/home/{product_config_id}/calculate",
*      tags={"Home"},
*      summary="Calcula el plan de pago de un producto crediticio",
*      description="Calcular el plan de pago de un producto crediticio",
* 
* @OA\Parameter(
*     name="product_config_id",
*     in="path",
*     required=true,
*     description="id del producto crediticio",
*     @OA\Schema(type="uuid")
*   ),
* 
* @OA\RequestBody(
*     description="Calcula el plan de pago",
*     required=true,
*    @OA\JsonContent(
*       type="object",
*       required={"principalAmount", "numberOfPeriods"},
 * @OA\Property(
 *         property="calculator",
 *         type="object",
 *         format="object",
 *         description="Datos de la calculadora",
 *         type="object",
 *       
 *       @OA\Property(
 *         property="principalAmount",
 *         type="int32",
 *         format="int32",
 *         example="1000000",
 *         description="Monto a solicitar"
 *       ),
 * @OA\Property(
 *         property="numberOfPeriods",
 *         type="int32",
 *         format="int32",
 *         example="6",
 *         description="Periodos a solicitar"
 *       ),
 * @OA\Property(
 *         property="startDate",
 *         type="date",
 *         format="date",
 *         example="2019-03-01",
 *         description="Fecha inicial del plan de pago"
 *       ),
 *      ),
*    )
* 
* ),
* 
 * @OA\Response(
 *     response=200,
 *     description="Cliente registrado con éxito",
 *     @OA\JsonContent(
 *       type="object",
 *       @OA\Property(
 *         property="success",
 *         type="boolean",
 *         format="boolean",
 *         example="true",
 *         description="Si hubo error",
 *       ),
 *      @OA\Property(
 *         property="code",
 *         type="integer",
 *         format="int32",
 *         example="0",
 *         description="Código del error"
 *       ),
 *      @OA\Property(
 *         property="locale",
 *         type="string",
 *         format="string",
 *         example="en",
 *         description="Lenguaje del mensaje"
 *       ),
 *      @OA\Property(
 *         property="message",
 *         type="string",
 *         format="string",
 *         example="OK",
 *         description="Mensaje de la respuesta"
 *       ),
 *       @OA\Property(
 *         property="data",
 *         type="object",
 *         format="object",
 *         description="Datos de retorno",
 *         type="object",
 *       @OA\Property(
 *         property="credit",
 *         type="array",
 *         format="array",
 *         description="Cuotas",
 *          @OA\Items(ref="#/components/schemas/Quota")
 *       )
 *      )
 *     )
 * ),
*),
*/



/**
 * @OA\Schema(
 *   schema="Source",
 *   type="object",
 *   format="object",
 *   description="La estructura general de una source",
*          @OA\Property(
 *              property="uuid",
 *              type="uuid",
 *              description="Identificador del source",
 *              example="3c1890b7-b28b-4ffd-8a1e-d237bb58289c"
 *          ),
 *          @OA\Property(
 *              property="name",
 *              type="string",
 *              description="Nombre del source",
 *              example="Por redes sociales"
 *          ),
 *          @OA\Property(
 *              property="description",
 *              type="string",
 *              format="string",
 *              description="Descripción del source"
 *          )
 * )
 */




/**
 * @OA\Schema(
 *   schema="Quota",
 *   type="object",
 *   format="object",
 *   description="La estructura general de una quota",
 *   @OA\Property(
 *         property="Interest",
 *         type="object",
 *         format="object",
 *         description="Interés Calculado",
 *          @OA\Property(
 *              property="cValue",
 *              type="float",
 *              format="float",
 *              description="Interés Calculado",
 *              example="36637.05005428852"
 *          ),
 *          @OA\Property(
 *              property="tValue",
 *              type="float",
 *              format="float",
 *              description="Iva del interés",
 *              example="0"
 *          ),
 *   ),
 *  @OA\Property(
 *         property="InsurancePerMonth",
 *         type="object",
 *         format="object",
 *         description="Seguro de Vida",
 *          @OA\Property(
 *              property="cValue",
 *              type="float",
 *              format="float",
 *              description="Seguro Calculado",
 *              example="1666.6666666666667"
 *          ),
 *          @OA\Property(
 *              property="tValue",
 *              type="float",
 *              format="float",
 *              description="Iva del Seguro",
 *              example="316.6666666666667"
 *          ),
 *   ),
 *      @OA\Property(
 *              property="total_charges",
 *              type="float",
 *              format="float",
 *              description="Valor unificado de los cargos",
 *              example="38620.383387621856"
 *          ),
 *      @OA\Property(
 *              property="date",
 *              type="float",
 *              format="float",
 *              description="Valor unificado de los cargos",
 *              example="38620.383387621856"
 *          ),
 *  @OA\Property(
 *              property="quota",
 *              type="float",
 *              format="float",
 *              description="Valor unificado de los cargos",
 *              example="189906.46939398354"
 *          ),
 *  @OA\Property(
 *              property="capital_cascade",
 *              type="float",
 *              format="float",
 *              description="Valor unificado de los cargos",
 *              example="151286.0860063617"
 *          ),
 *  @OA\Property(
 *              property="capital_quota",
 *              type="float",
 *              format="float",
 *              description="Valor unificado de los cargos",
 *              example="151286.0860063617"
 *          ),
 *  @OA\Property(
 *              property="capital_paid",
 *              type="float",
 *              format="float",
 *              description="Valor unificado de los cargos",
 *              example="151286.0860063617"
 *          ),
 *  @OA\Property(
 *              property="capital_pending",
 *              type="float",
 *              format="float",
 *              description="Valor unificado de los cargos",
 *              example="1000000"
 *          ),
 *  @OA\Property(
 *              property="day_payment",
 *              type="float",
 *              format="float",
 *              description="Valor unificado de los cargos",
 *              example="189906.46939398354"
 *          ),
 *  @OA\Property(
 *              property="pay_acum",
 *              type="float",
 *              format="float",
 *              description="Valor unificado de los cargos",
 *              example="189906.46939398354"
 *          ),
 * 
 * )
 */

/*
{
    "Interest": {
        "cValue": 36637.05005428852,
        "tValue": 0
    },
    "InsurancePerMonth": {
        "cValue": 1666.6666666666667,
        "tValue": 316.6666666666667
    },
    "total_charges": 38620.383387621856,
    "date": {
        "date": "2019-04-01 00:00:00.000000",
        "timezone_type": 3,
        "timezone": "UTC"
    },
    "quota": 189906.46939398354,
    "capital_cascade": 151286.0860063617,
    "capital_quota": 151286.0860063617,
    "capital_paid": 151286.0860063617,
    "capital_pending": 1000000,
    "day_payment": 189906.46939398354,
    "paid_acum": 189906.46939398354
}, */

//Route::post('home/{product_config_id}/calculate', 'Contacts\ContactsController@homeProductConfigCalculate');