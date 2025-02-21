<?php

class Autoload
{
    private array $carpetas;

    public function __construct(array $carpetas)
    {
        $this->carpetas = $carpetas;
    }

    public function cargarClase(string $clase): void
    {
        foreach ($this->carpetas as $carpeta) {
            $rutaClase = __ROOT__ . "classes/$carpeta/$clase.php";
            $rutaClaseAlternativa = __ROOT__ . "classes/$carpeta/$clase.class.php";

            if (file_exists($rutaClase)) {
                include $rutaClase;
                return;
            }

            if (file_exists($rutaClaseAlternativa)) {
                include $rutaClaseAlternativa;
                return;
            }
        }

        throw new Exception("No se encontró la definición de la clase: $clase");
    }

    public function registrar(): void
    {
        spl_autoload_register([$this, "cargarClase"]);
    }
}
