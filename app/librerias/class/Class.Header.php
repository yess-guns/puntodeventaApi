<?php
class Header extends Controlador
{


  public function __construct()
  {
    $this->db = $this->modelos('modeloHeader');
  }
  function getHeader()
  {
    $header =  apache_request_headers();
    $auth = (empty($header['Authorization'])) ? '' : $header['Authorization'];
    return $this->db->validToken($auth);
  }
}
