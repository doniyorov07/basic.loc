<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            if (Yii::$app->user->can('admin'))
            {
                echo \hail812\adminlte\widgets\Menu::widget([
                    'items' => [
                        ['label' => 'Yii2 PROVIDED', 'header' => true],
                        ['label' => 'Tag',  'icon' => 'file-code', 'url' => ['/admin/tag/index']],
                        ['label' => 'Category',  'icon' => 'file-code', 'url' => ['/admin/category/index']],
                        ['label' => 'Post',  'icon' => 'file-code', 'url' => ['/admin/post/index']],
                        ['label' => 'Userlar',  'icon' => 'fa fa-user', 'url' => ['/admin/default/appuser']],
                    ],
                ]);
            }elseif (Yii::$app->user->can('manager')) {
                echo \hail812\adminlte\widgets\Menu::widget([
                    'items' => [
                        ['label' => 'Yii2 PROVIDED', 'header' => true],
                        ['label' => 'Tag', 'icon' => 'file-code', 'url' => ['/admin/tag/index']],
                        ['label' => 'Category', 'icon' => 'file-code', 'url' => ['/admin/category/index']],
                        ['label' => 'Post', 'icon' => 'file-code', 'url' => ['/admin/post/index']],
                    ],
                ]);
            }

            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>