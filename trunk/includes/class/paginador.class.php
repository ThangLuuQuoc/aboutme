<?php
/**
 * paginador.class.php
 *
 * Fecha de Creación: 04/01/2008
 *
 * @author Julián
 * @package class
 */

/**
 * Class Paginador
 *
 * Se utiliza para el manejo de la paginacion.
 */
class Paginador
{
	private $datos;
	private $ver;
	private $posicion;
	private $numFilas;
	private $totalPaginas;
	private $paginaActual;
	private $posicionAnterior;	
	private $btnAnterior;
	private $btnSiguiente;
	private $listaPaginas;	

	/**
	 * __construct() - Inicializa los atributos del Paginador.
	 *
	 * @param lista $datos Datos que requieren ser paginados.
	 * @param int $ver Numero de ítems a listar en cada página.
	 * @param int $numEnlaces Número de paginas en la lista de numeros del paginador.
	 * @param int $posicion Número de página a mostrar para seleccion de la lista. 
	 * @param int $numFilas Total de filas de la consulta sin paginación.
	 * @param int $tipoPaginador 0 paginador con enlaces 2 paginador ajax.
	 */
	public function __construct($datos,$ver = 25,$numEnlaces=5,$posicion = 0,$numFilas, $tipoPaginador=0, $parametrosBusqueda='')
	{	
		$this->datos = $datos;
		$this->ver = $ver;
		if($posicion >= $numFilas && $numFilas > 0)
			while($posicion >= $numFilas)
				$posicion-=$ver;
		$this->posicion = $posicion;
		
		$this->numFilas = $numFilas;
		if($this->ver>0)
		{
			$this->totalPaginas = ceil(($this->numFilas) / $this->ver);		
			$this->paginaActual = floor($this->posicion / $this->ver) + 1;
			$this->posicionSiguiente = ($this->posicion + $this->ver);
			$this->posicionAnterior = $this->posicion - $this->ver;
		}
	
		if($tipoPaginador==0)
			$this->barraNavegacion($numEnlaces,$parametrosBusqueda);
		else
			$this->barraNavegacionAjax($numEnlaces, $tipoPaginador);
	}
	
	/**
	 * obtenerAtributoPaginador() - Retorna el valor del atributo especificado.
	 *
	 * @param string $atributo
	 * @return valor de atributo solicitado
	 */
	public function obtenerAtributoPaginador($atributo)
		{
				switch($atributo)
				{
					case "btnSiguiente" :	return $this->btnSiguiente; break;
					case "btnAnterior" :	return $this->btnAnterior; break;
					case "listaPaginas" :	return $this->listaPaginas; break;
					case "totalPaginas" :	return $this->totalPaginas; break;
					case "paginaActual" :	return $this->paginaActual; break;
				}
		}

	/**
	 * filasPag() - Retorna el arreglo de objetos de la pagina solicitada.
	 *
	 * @return Arreglo de objetos
	 */
	public function filasPag()
	{
		if($this->numFilas >= $this->posicion + $this->ver)
			for($i=0; $i<$this->ver; $i++)
			{		
				$rs[$i]=$this->datos[$this->posicion+$i];
			}
		else
		{
			for($i=0; $i<$this->numFilas - $this->posicion; $i++)
			{		
				$rs[$i]=$this->datos[$this->posicion+$i];
			}
		}
		return $rs;
	}
	
	/**
	 * barraNavegacion() - asigna los valores a: btnAnterior, btnSiguiente, listaPaginas.
	 *
	 * @param int $numEnlaces
	 */
	private function barraNavegacion($numEnlaces,$parametrosBusqueda)
	{	       
	  $npg = $this->totalPaginas;
		$pa= $this->paginaActual;
		$posicion= $this->posicion;
		$paginavnumenlaces=$numEnlaces;
		$anterior ='';
		$paginas ='&nbsp;';
		$siguiente ='';
        
		if (isset($pa) && $pa > 1)
		{ 					
			 $anterior = '?init='.($this->posicionAnterior).'&amount='.($this->ver).$parametrosBusqueda;
		}
			
		if(isset($pa) && ($pa+1) <= $npg)
		{
			$siguiente = '?init='.($this->posicionSiguiente).'&amount='.($this->ver).$parametrosBusqueda;
		}

		if(!isset($paginavnumenlaces))
		{					
			$paginavdesde = 1;
			$paginavhasta = $npg;
	 	}
		else
		{					
			$paginavintervalo = ceil($paginavnumenlaces/2) - 1;			
			$paginavdesde = $pa - $paginavintervalo;					
			$paginavhasta = $pa + $paginavintervalo;
			
			if($paginavdesde < 1)
			{
				$paginavhasta -= ($paginavdesde - 1);
				$paginavdesde = 1;
			}
				
			if($paginavhasta > $npg)
			{
				$paginavdesde -= ($paginavhasta - $npg);
				$paginavhasta = $npg;
				
				if($paginavdesde < 1)
				{
					$paginavdesde = 1;
				}
			}
		}
				
		if(isset($npg) && $npg >=1)
		{
			for($k=$paginavdesde;$k<=$paginavhasta;$k++)
			{
				if($k == $pa)
				{
					if($k == $paginavdesde)
						$paginas .= ' &nbsp;<span><strong>'.$pa.'</strong></span>';
					else
						$paginas .= ' &nbsp;<span><strong>'.$pa.'</strong></span>';
				}
				else
				{
					if($k == $paginavdesde)
						$paginas.=' &nbsp;<a href="?init='.(floor(($this->ver*$k)-$this->ver)).'&amount='.($this->ver).$parametrosBusqueda.'" style="text-decoration:none;color:#999999">'.$k.'</a>';		
					else
						$paginas.=' &nbsp;<a href="?init='.(floor(($this->ver*$k)-$this->ver)).'&amount='.($this->ver).$parametrosBusqueda.'" style="text-decoration:none;color:#999999">'.$k.'</a>';			
				}						
			}
		}					
		$this->btnAnterior = $anterior;
		$this->btnSiguiente = $siguiente;
		$this->listaPaginas = $paginas;						
	}
	
	/**
	 * barraNavegacionAjax() - asigna los valores a: btnAnterior, btnSiguiente, listaPaginas.
	 *
	 * @param int $numEnlaces
	 * @param int $tipoPaginador
	 */
	private function barraNavegacionAjax($numEnlaces, $tipoPaginador)
	{	       
	  $npg = $this->totalPaginas;
		$pa= $this->paginaActual;
		$posicion= $this->posicion;
		$paginavnumenlaces=$numEnlaces;
		$anterior ='';
		$paginas ='&nbsp;';
		$siguiente ='';
        
		if (isset($pa) && $pa > 1)
		{ 					
			 $anterior = 'javascript:paginarAjax('.($this->posicionAnterior).', '.($this->ver).');';
		}
			
		if(isset($pa) && ($pa+1) <= $npg)
		{
			$siguiente = 'javascript:paginarAjax('.($this->posicionSiguiente).', '.($this->ver).');';
		}

		if(!isset($paginavnumenlaces))
		{					
			$paginavdesde = 1;
			$paginavhasta = $npg;
	 	}
		else
		{					
			$paginavintervalo = ceil($paginavnumenlaces/2) - 1;			
			$paginavdesde = $pa - $paginavintervalo;					
			$paginavhasta = $pa + $paginavintervalo;
			
			if($paginavdesde < 1)
			{
				$paginavhasta -= ($paginavdesde - 1);
				$paginavdesde = 1;
			}
				
			if($paginavhasta > $npg)
			{
				$paginavdesde -= ($paginavhasta - $npg);
				$paginavhasta = $npg;
				
				if($paginavdesde < 1)
				{
					$paginavdesde = 1;
				}
			}
		}
				
		if($tipoPaginador==2)
		{
			if(isset($npg) && $npg >=1)
			{
				for($k=$paginavdesde;$k<=$paginavhasta;$k++)
				{
					if($k == $pa)
					{
						if($k == $paginavdesde)
							$paginas = '<span><strong>'.$pa.'</strong></span>';
						else
							$paginas .= ' -&nbsp;<span><strong>'.$pa.'</strong></span>';
					}
					else
					{
						if($k == $paginavdesde)
							$paginas='<a href="javascript:paginarAjax('.(floor(($this->ver*$k)-$this->ver)).', '.($this->ver).');" >'.$k.'</a>';		
						else
							$paginas.=' -&nbsp;<a href="javascript:paginarAjax('.(floor(($this->ver*$k)-$this->ver)).', '.($this->ver).');" >'.$k.'</a>';			
					}						
				}
			}					
		}
		else
			{
				if(isset($npg) && $npg >=1)
				{
					for($k=$paginavdesde;$k<=$paginavhasta;$k++)
					{
						if($k == $pa)
						{
							if($k == $paginavdesde)
								$paginas .= ' &nbsp;<span><strong>'.$pa.'</strong></span>';
							else
								$paginas .= ' &nbsp;<span><strong>'.$pa.'</strong></span>';
						}
						else
						{
							if($k == $paginavdesde)
								$paginas.=' &nbsp;<a href="javascript:paginarAjax('.(floor(($this->ver*$k)-$this->ver)).', '.($this->ver).');" >'.$k.'</a>';		
							else
								$paginas.=' &nbsp;<a href="javascript:paginarAjax('.(floor(($this->ver*$k)-$this->ver)).', '.($this->ver).');" >'.$k.'</a>';			
						}						
					}
				}
			}
		$this->btnAnterior = $anterior;
		$this->btnSiguiente = $siguiente;
		$this->listaPaginas = $paginas;						
	}
	
}	
?>