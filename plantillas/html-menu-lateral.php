<!-- Barra lateral -->
<div class="menu_lateral">
    <ul>
        
        <li>
            <a class="show_submenu" data-show-submenu="submenu_2" href="#">
                <span class="menu_lateral__icon"><i class="fas fa-cog"></i></span>
                <span class="menu_lateral__texto">Establecimiento</span>
                <span class="menu_lateral__sub_icon"><i class="fas fa-caret-down first"></i></span>
            </a>
            <ul id="submenu_2" class="submenu">
                <li>
                    <a href="<?php echo RUTA_CAJAS_COBRO ?>">
                        <span class="menu_lateral__icon"><i class="far fa-circle"></i></i></span>
                        <span class="menu_lateral__texto">CAJAS DE COBRO</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo RUTA_MESAS_SERVICIO; ?>">
                        <span class="menu_lateral__icon"><i class="far fa-circle"></i></i></span>
                        <span class="menu_lateral__texto">MESAS DE SERVICIO</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo RUTA_PUESTOS_TRABAJO; ?>">
                        <span class="menu_lateral__icon"><i class="far fa-circle"></i></i></span>
                        <span class="menu_lateral__texto">PUESTOS DE TRABAJO</span>
                    </a>
                </li>

            </ul>
        </li>
        
        <li>
            <a class="show_submenu" data-show-submenu="submenu_1" href="#">
                <span class="menu_lateral__icon"><i class="fas fa-users"></i></span>
                <span class="menu_lateral__texto">Personas</span>
                <span class="menu_lateral__sub_icon"><i class="fas fa-caret-down first"></i></span>
            </a>
            <ul id="submenu_1" class="submenu">

                <li>
                    <a href="<?php echo RUTA_GESTOR_EMPLEADOS; ?>">
                        <span class="menu_lateral__icon"><i class="far fa-circle"></i></i></span>
                        <span class="menu_lateral__texto">EMPLEADOS</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo RUTA_GESTOR_USUARIOS; ?>">
                        <span class="menu_lateral__icon"><i class="far fa-circle"></i></i></span>
                        <span class="menu_lateral__texto">USUARIOS</span>
                    </a>
                </li>
                
                <li>
                    <a href="<?php echo RUTA_GESTOR_PROVEEDORES; ?>">
                        <span class="menu_lateral__icon"><i class="far fa-circle"></i></i></span>
                        <span class="menu_lateral__texto">proveedores</span>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a class="show_submenu" data-show-submenu="submenu_3" href="#">
                <span class="menu_lateral__icon"><i class="fas fa-archive"></i></span>
                <span class="menu_lateral__texto">Insumos</span>
                <span class="menu_lateral__sub_icon"><i class="fas fa-caret-down first"></i></span>
            </a>
            <ul id="submenu_3" class="submenu">

                <li>
                    <a href="<?php echo RUTA_REGISTRAR_INSUMO; ?>">
                        <span class="menu_lateral__icon"><i class="far fa-circle"></i></i></span>
                        <span class="menu_lateral__texto">Registrar Insumo</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo RUTA_GESTOR_INSUMOS; ?>">
                        <span class="menu_lateral__icon"><i class="far fa-circle"></i></i></span>
                        <span class="menu_lateral__texto">Gestor Insumos</span>
                    </a>
                </li>
                
            </ul>
        </li>

        <li>
            <a class="show_submenu" data-show-submenu="submenu_4" href="#">
                <span class="menu_lateral__icon"><i class="fab fa-product-hunt"></i></span>
                <span class="menu_lateral__texto">Productos</span>
                <span class="menu_lateral__sub_icon"><i class="fas fa-caret-down first"></i></span>
            </a>
            <ul id="submenu_4" class="submenu">


                <li>
                    <a href="<?php echo RUTA_CATEGORIA_PRODUCTOS; ?>">
                        <span class="menu_lateral__icon"><i class="far fa-circle"></i></i></span>
                        <span class="menu_lateral__texto">Categoria producto</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo RUTA_REGISTRAR_PRODUCTO; ?>">
                        <span class="menu_lateral__icon"><i class="far fa-circle"></i></i></span>
                        <span class="menu_lateral__texto">Registrar producto</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo RUTA_GESTOR_PRODUCTOS; ?>">
                        <span class="menu_lateral__icon"><i class="far fa-circle"></i></i></span>
                        <span class="menu_lateral__texto">Gestor Productos</span>
                    </a>
                </li>

            </ul>
        </li>
        <!--
        <li>
            <a class="show_submenu" data-show-submenu="submenu_5" href="#">
                <span class="menu_lateral__icon"><i class="fas fa-cart-arrow-down"></i></span>
                <span class="menu_lateral__texto">ventas</span>
                <span class="menu_lateral__sub_icon"><i class="fas fa-caret-down first"></i></span>
            </a>
            <ul id="submenu_5" class="submenu">

                <li>
                    <a href="<?php // echo RUTA_MESAS_SERVICIO; ?>">
                        <span class="menu_lateral__icon"><i class="far fa-circle"></i></i></span>
                        <span class="menu_lateral__texto">Aperturar caja</span>
                    </a>
                </li>

                <li>
                    <a href="<?php // echo RUTA_GESTOR_VENTAS; ?>">
                        <span class="menu_lateral__icon"><i class="far fa-circle"></i></i></span>
                        <span class="menu_lateral__texto">Gestor Ventas</span>
                    </a>
                </li>

            </ul>
        </li>
        -->
    </ul>
</div>
