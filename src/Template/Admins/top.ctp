<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"> -->
        <title>
            <?= LT['007'] ?>:
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>
        <?= $this->Html->script('jquery-3.1.0.min.js') ?>
        <?= $this->Html->script('materialize.min.js') ?>
        <?= $this->Html->css('materialize.css') ?>
        <?= $this->Html->css('night-planet.css') ?>
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body>
        <?= $this->Flash->render() ?>
        <div class="or-card">
            <div class="card-image waves-block">
                <div class="or-form-wrap">
                    <h3 class="center-align"><?= LT['001'] ?></h3>
                </div>
                <div class="card-content center-align">
					<div class="row">
						<div class="col s12 m12 l12">
							<a href="owner/owners" class="waves-effect waves-light btn-large">オーナーログイン</a>
						</div>
					</div>
					<div class="row">
						<div class="col s12 m12 l12">
							<a href="cast/casts" class="waves-effect waves-light btn-large">スタッフログイン</a>
						</div>
					</div>
				</div>
            </div>
        </div>
    </body>
</html>


