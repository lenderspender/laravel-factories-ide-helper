override(\factory(0), map([
        '' => '@FactoryBuilder',
    <?php foreach ($factories as $factory): ?>
    '\<?=$factory->namespace . '\\' . $factory->class; ?>' => \<?=$factory->namespace . '\\' . $factory->class; ?>FactoryBuilder::class,
    <?php endforeach; ?>
]));