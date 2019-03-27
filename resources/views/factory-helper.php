<?= '<?php'; ?>

// @formatter:off

/**
* A helper file for Laravel 5, to provide autocomplete information for laravel factories to your IDE
* Generated for Laravel <?= $version; ?> on <?= now()->format('Y-m-d H:i:s'); ?>.
*
* This file should not be included in your code, only analyzed by your IDE!
*/

<?php foreach ($namespaces as $namespace => $classes): ?>
namespace <?=$namespace; ?> {
        <?php foreach ($classes as $class): ?>
/**
        * @method \Illuminate\Database\Eloquent\Collection|<?=$class->class; ?>[]|<?=$class->class; ?> create($attributes = [])
        * @method \Illuminate\Database\Eloquent\Collection|<?=$class->class; ?>[]|<?=$class->class; ?> make($attributes = [])
        */
        class <?=$class->class; ?>FactoryBuilder extends \Illuminate\Database\Eloquent\FactoryBuilder {}
        <?php endforeach; ?>
}
<?php endforeach; ?>
