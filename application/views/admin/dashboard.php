

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-12">
                    <h3 class="page-title">Admin <?= $heading?></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-sm-6 col-12">
                <a href="<?= admin_url('users')?>">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon bg-primary">
                                    <i class="far fa-user"></i>
                                </span>
                                <div class="dash-widget-info">
                                    <h3><?= count($total_user)?></h3>
                                    <h6 class="text-dark">All Users</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-6 col-sm-6 col-12">
                <a href="<?= admin_url('manage_prayers')?>">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon bg-primary">
                                    <i class="fas fa-list"></i>
                                </span>
                                <div class="dash-widget-info">
                                    <h3><?= count($total_event)?></h3>
                                    <h6 class="text-dark">All Events</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-6 col-sm-6 col-12">
                <a href="<?= admin_url('manage_podcast')?>">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon bg-primary">
                                    <i class="fa fa-cogs"></i>
                                </span>
                                <div class="dash-widget-info">
                                    <h3><?= count($total_podcast)?></h3>
                                    <h6 class="text-dark">All Podcasts</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-6 col-sm-6 col-12">
                <a href="<?= admin_url('manage_videos')?>">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon bg-primary">
                                    <i class="fa fa-bookmark"></i>
                                </span>
                                <div class="dash-widget-info">
                                    <h3><?= count($total_videos)?></h3>
                                    <h6 class="text-dark">All Videos</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">

        </div>
    </div>
</div>
</div>
