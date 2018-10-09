<?php

class Estrattore
{
    private $fieldsAnnotations = [];

    private $className;

    private $container;

    public function __construct($className)
    {
        $this->className = $className;

        $this->container = ContainerLoader::load();
    }

    private function parse()
    {
        $properties = $this->container->get('property.reader')
            ->learnClassName($this->className)
            ->lookForPropertiesOnClass();

        foreach($properties as $prop) {
            $this->fieldsAnnotations[$prop->name] = [];

            $ref = new ReflectionProperty($this->className, $prop->name);
            $comment = $ref->getDocComment();

            $re = '/@([\\\\\w]+)\((?:|(.*?[]"}]))\)/s';
            $re = '/@(Annotation|ValueObject|Json)\((?:|(.*?[]"}]))\)/s';
            preg_match_all($re, $comment, $matches, PREG_SET_ORDER, 0);

            // Print the entire match result
            foreach($matches as $match) {
                $cleanJsonInAnnotation = '';
                if (isset($match[2])) {
                    foreach ($lines = explode("\n", $match[2]) as $line) {
                        $cleanJsonInAnnotation .= trim(str_replace(" * ", "", $line));
                    }

                    if (method_exists($match[1], "box")) {
                        $token = join("", explode("\n", $cleanJsonInAnnotation));
                        $json = json_decode($cleanJsonInAnnotation, true) ?? [];
                        $this->fieldsAnnotations[$prop->name] = $json; // $match[1]::box($json);
                    } elseif ($instance = new $match[1]()) {
                        $this->fieldsAnnotations[$prop->name] = $instance;
                    } else {
                        throw new \RuntimeException(
                            'Oops! Invalid Annotation constructor for annotation ' . $match[1]
                        );
                    }
                }
            }
        }
    }

    public function getVo()
    {
        $this->parse();

        return [
            '_fields' => $this->fieldsAnnotations,
        ];
    }
}
