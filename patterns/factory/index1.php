<?php

namespace Patterns\Factory\Conceptual;

echo "Abstract Factory Pattern\n";
echo "=========================\n";

interface Button
{
    public function render(): string;
}

class ButtonHTML implements Button
{
    public function render(): string
    {
        return "<button>Test</button>";
    }
}

class BottonWin implements Button
{
    public function render(): string
    {
        return "Windows::Button";
    }
}

interface GUIFactory
{
    public function createButton(): Button;
    public function applyTheme();
}

class HTMLFactory implements GUIFactory
{
    public function applyTheme() {
        echo "<style>button {background-color: #4CAF50; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;}</style>";
    }

    public function createButton(): Button
    {
        return new ButtonHTML();
    }
}

class WinFactory implements GUIFactory
{
    public function applyTheme() {
        echo "Applying Windows theme\n";
    }

    public function createButton(): Button
    {
        return new BottonWin();
    }
}

class Application {
    private $factory;

    public function __construct(GUIFactory $factory = null) {
        $this->factory = $factory;
    }

    public function createUI() {
        $this->factory->applyTheme();
        $button = $this->factory->createButton();
        echo $button->render();
    }
}

$type = 'html';
$factory = $type  == 'html' ? new HTMLFactory() : new WinFactory();
$App = new Application($factory);
$App->createUI();


/*
function clientCode(GUIFactory $factory)
{
    $button = $factory->createButton();
    echo $button->render();
}

echo "Testing HTML Factory\n";
clientCode(new HTMLFactory());
echo "\n\n";

echo "Testing Windows Factory\n";
clientCode(new WinFactory());
echo "\n\n";
*/