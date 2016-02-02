<?php
/**
 * Created by PhpStorm.
 * User: juanluis
 * Date: 2/2/16
 * Time: 12:11
 */

namespace AppBundle\Twig;

use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TablonExtension extends \Twig_Extension
{
    /**
     * @var Packages
     */
    private $packages;

    /**
     * @var string
     */
    private $uploads_directory_name;

    /**
     * @param Packages $packages
     * @param $uploads_directory_name
     */
    public function __construct(Packages $packages, $uploads_directory_name)
    {
        $this->packages = $packages;
        $this->uploads_directory_name = $uploads_directory_name;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('visualizar_archivo', [$this, 'visualizar_archivo'], ['is_safe' => ['html']]),
        );
    }

    /**
     * @param $filename
     * @return string
     */
    public function visualizar_archivo($filename)
    {
        $pathFile = $this->uploads_directory_name.'/'.$filename;
        $file = new File($pathFile);

        $img = ['png', 'jpg', 'jpeg', 'gif', 'svg', 'pjpeg'];

        if (in_array($file->getExtension(), $img)) {
            return '<img src="'.$this->packages->getUrl($pathFile).'" height="60">';
        }

        return '<a href="'.$this->packages->getUrl($pathFile).'" download>Descargar archivo</a>';
    }

    public function getName()
    {
        return 'emergya.twig.extension';
    }
}