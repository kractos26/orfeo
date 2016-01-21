<? /**
 * Error es la clase basica encargada de gestionar los mensajes de error presentados durante la ejecucion de un proceso
 * @author      Sixto Angel Pinz�n
 * @version     1.0
 */

class Error {	 

  /**
   * Variable que indica el codigo del error
   * @var numeric
   * @access public
   */
	var $code;
	
  /**
   * Variable que indica el mensaje asociado con el tipo de error
   * @var numeric
   * @access public
   */
	var $message;    	

   /** 
	* Constructor encargado de inicializar el c�digo de error
	* @param	$code	Es el c�digo del error
	* @return   void
	*/
    function Error($code = 0) {
    	$this->code=$code;
    }
	
    /** 
     * Retorna el valor string correspondiente al atributo texto del error
     * @return   string
     */
    function getMessage() {
    	return $this->message;
   	}
   	
   	/** 
	* Funcion encargada de asignar el texto del mensaje de error
	* @param	$mess	Es el texto del error
	* @return   void
	*/
   	function setMessage($mess){
   		$this->message=$mess;
   	}
   	
   	/** 
	* Funcion encargada de asignar el texto del mensaje de error añadiendo el parametro de entrada al valor actual del mensaje
	* @param	$mess	Es el texto del error
	* @return   void
	*/
   	function setMessageAdd($mess){
   		$this->message="<span class='alarmas'>".$mess."</span>".$this->message;
   	}
}

?>