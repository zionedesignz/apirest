<?php

class Paginacion{
 
    public function getPaging($page, $total_rows, $regs, $page_url){
 
        // array paginación
        $paging_arr = [];
        $paging_arr['pages'] = [];
        $page_count = 0;
        $limit = $regs;
 
        // url para la primera página (si la pagina activa es la primera dejar vacía)
        $paging_arr["first"] = $page>1 ? "{$page_url}page=1&limit={$limit}" : "";
 
        // calcular num de paginas 
        $total_pages = ceil($total_rows / $regs);
 
        // rango de url's a mostrar
        $range = 2;
 
        // mostrar enlaces a 'rango de páginas' alrededor de 'página actual'
        $initial_num = $page - $range;
        $condition_limit_num = ($page + $range)  + 1;
 
         
        for($x=$initial_num; $x<$condition_limit_num; $x++){
            // asegúrese de que '$x sea mayor que 0' y 'menor o igual que $total_pages'
            if(($x > 0) && ($x <= $total_pages)){
                $paging_arr['pages'][$page_count]["page"]=$x;
                $paging_arr['pages'][$page_count]["url"]="{$page_url}page={$x}&limit={$limit}";
                $paging_arr['pages'][$page_count]["current_page"] = $x==$page ? "yes" : "no";
 
                $page_count++;
            }
        }
 
        // url para la última página (si la pagina activa es la última dejar vacía)
        $paging_arr["last"] = $page<$total_pages ? "{$page_url}page={$total_pages}&limit={$limit}" : "";
 
        // devolver array JSON
        return $paging_arr;
    }
 
}

?>