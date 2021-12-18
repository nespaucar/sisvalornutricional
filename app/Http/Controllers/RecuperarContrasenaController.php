<?php

namespace App\Http\Controllers;

use Validator;
use Hash;
use App\Models\Bitacora;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecuperarContrasenaController extends Controller
{
    public function recuperarPassword(Request $request) {
        $validacion = Validator::make($request->all(),
            array(
                'email' => 'required|email|max:120',
            )
        );
        if ($validacion->fails()) {
            return json_encode('El correo es requerido. Comprueba también el formato.');
        }
        $retorno = 'OK';
        $error = DB::transaction(function() use($request, &$retorno) {        	
            $user     = Usuario::where('email', '=', $request->email)->first();
            if($user === NULL) {
            	$retorno = 'El correo no se encuentra en nuestros registros. Vuelve a intentar.';
            } else {
            	$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$new_pass = substr(str_shuffle($permitted_chars), 0, 8);
            	$user->password = Hash::make($new_pass);
            	$user->save();

            	$correo = $user->email;
			    $contra = $new_pass;
			    $dni = $user->login;
			    $cabeceras = 'MIME-Version: 1.0' . "\r\n";
			    $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			    $cabeceras .= 'From: SistemaPagosMuniSanIgnacio';
			    $message = '<html> 
                    <head> 
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
                        <title>Demystifying Email Design</title> 
                        <meta name="viewport" content="width=device-width, initial-scale=1.0"/> 
                    </head>
                    <body> 
                        <table cellpadding="0" cellspacing="0" width="100%" style="border: solid 1px white; border-collapse: collapse;"> 
                            <tr> 
                                <table cellpadding="0" cellspacing="0" width="100%"> 
                                    <tr>
                                        <td valign="top"> 
                                            <table cellpadding="0" cellspacing="0" width="100%" style="text-align: center;"> 
                                                <tr style="background-color: #658EC6;"> 
                                                    <td align="center">
                                                        <a href="https://munisanignacio.gob.pe/" target="_blank">
                                                            <img src="assets/images/logo.png" alt="" height="50%" style="display: block; padding: 20px;"/> 
                                                        </a>                                        
                                                    </td> 
                                                </tr> 
                                                <tr style="background-color: #E3FF7A;"> 
                                                    <td style="padding: 15px; font-family: Arial, sans-serif;"> 
                                                        Usted ha solicitado recuperación de su contraseña en el sistema de Pagos. Su información es la siguiente: 
                                                    </td> 
                                                </tr> 
                                            </table> 
                                        </td> 
                                    </tr> 
                                </table>
                            </tr> 
                            <tr>
                                <table cellpadding="0" cellspacing="0" width="100%" style="text-align: center;"> 
                                    <tr> 
                                        <td valign="top" width="50%">                    
                                            <table cellpadding="0" cellspacing="0" width="100%" style="text-align: center; background-color: #E5EFF1;">                  
                                                <tr>                     
                                                    <td align="center">                  
                                                        <img src="http://munisanignacio.gob.pe/gestionpagos/assets/images/usuario.png" alt="" width="80" height="80" style="display: block; padding: 20px;" />                        
                                                    </td>                
                                                </tr>
                                            </table>                     
                                        </td>
                                        <td valign="top" width="50%">                    
                                            <table cellpadding="0" cellspacing="0" width="100%" style="text-align: center; background-color: #E5EFF1;">                  
                                                <tr>                     
                                                    <td align="center">
                                                        <img src="http://munisanignacio.gob.pe/gestionpagos/assets/images/contrasena.png" alt="" width="80" height="80" style="display: block; padding: 20px;" />                             
                                                    </td>                
                                                </tr>
                                            </table>                     
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">
                                            <table cellpadding="0" cellspacing="0" width="100%" style="text-align: center; background-color: #C4E3EA;">                          
                                                <tr>                             
                                                    <td style="padding: 5px; font-family: Arial, sans-serif; font-size: 14px;">                          
                                                        <b>Usuario/DNI</b>
                                                    </td>                            
                                                </tr>
                                                <tr>                             
                                                    <td style="padding: 5px; font-family: Arial, sans-serif; font-size: 14px;">                          
                                                        <b>Contraseña</b>
                                                    </td>                            
                                                </tr>                            
                                            </table> 
                                        </td>
                                        <td valign="top">
                                            <table cellpadding="0" cellspacing="0" width="100%" style="text-align: center; background-color: #E5EFF1;">                          
                                                <tr>                             
                                                    <td style="padding: 5px; font-family: Arial, sans-serif; font-size: 14px;">                          
                                                        ' . $dni . '
                                                    </td>                            
                                                </tr>
                                                <tr>                             
                                                    <td style="padding: 5px; font-family: Arial, sans-serif; font-size: 14px;">                          
                                                        ' . $contra . '
                                                    </td>                            
                                                </tr>                            
                                            </table> 
                                        </td> 
                                    </tr> 
                                </table>
                            </tr>
                            <tr>
                                <td bgcolor="#658EC6" style="padding: 30px 30px 30px 30px;"> 
                                    <table cellpadding="0" cellspacing="0" width="100%" style="text-align: center;" > 
                                        <tr> 
                                            <td style="font-family: Arial, sans-serif; font-size: 14px; background-color: #E3FF7A; padding: 5px;"> 
                                                &reg; Sistema de Pagos
                                                <a href="https://munisanignacio.gob.pe/gestionpagos/login" target="_blank"><font>Da click para acceder</font></a> a nuestro sitio Web de Pagos
                                            </td> 
                                            <td align="center" style="background-color: #c4e3ea;">
                                                <a href="https://munisanignacio.gob.pe/" target="_blank">
                                                    <img src="https://www.convocatoriasdetrabajo.com/imagenes/organizaciones/th-imagen-MUNICIPALIDAD-PROVINCIAL-SAN-IGNACIO.jpg" alt="" height="38" style="display: block; padding: 5px;"/> 
                                                </a>                                        
                                            </td>
                                        </tr> 
                                    </table> 
                                </td>
                            </tr>
                        </table> 
                    </body> 
                </html>';

		    	$bitacora = new Bitacora();
	            $bitacora->fecha = date('Y-m-d');
	            $bitacora->descripcion = 'Se RECUPERA CONTRASEÑA de usuario ' . $user->persona->nombres;
	            $bitacora->tabla = 'USUARIO';
	            $bitacora->tabla_id = $user->id;
	            $bitacora->usuario_id = $user->id;
	            $bitacora->save();

	            $ch = curl_init("https://munisanignacio.gob.pe/send.php?action=SEND&mail=" . $correo . "&clave=" . $contra . "&dni=" . $dni);
	    		$result = curl_exec($ch);
	    		curl_close($ch);
            }	            
        });
        return json_encode(is_null($error) ? $retorno : $error);
    }
}