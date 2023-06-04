<div style="height:200px;" class="row section card">
  <div class="col s12">
      <?php if(!empty($news)): ?>
        <dl class="title center-align">
          <h6 style="font-weight: 600;color: deepskyblue;">ナイプラ NEWS</h6>
          <dt>
            <p>事務局からのお知らせです</p>
          </dt>
        </dl>
        <div style="border-style: solid;border-color: aquamarine;border-width: 0.1em;" id="info-marquee" class="col s12 card">
        <div class="">
          <?php if(count($news) > 0): ?>
            <ul id="marquee" class="marquee collection">
            <?php foreach ($news as $key1 => $row1):?>
              <?php foreach ($row1 as $key2 => $row2):?>
                <li class="dismissable">
                  <a href="/news/#<?=$key2?>">
                    <?='【'.$row2->created->nice().'】'.$row2['title']?>
                  </a>
                </li>
              <?php endforeach ?>
            <?php endforeach ?>
            </ul>
          <?php else: ?>
            <ul id="marquee" class="marquee collection">
              <li class="dismissable">
                <a href="#!" class="">
                  最近の更新はありません…。
                </a>
              </li>
            </ul>
          <?php endif; ?>
        </div>
      </div>
      <?php elseif(!empty($shop)): ?>
        <dl class="title center-align">
          <h6 style="font-weight:600;color:coral;"><?='【' . $shop->name . '】の更新情報'?></h6>
        </dl>
        <div style="border-style: solid;border-color: aquamarine;border-width: 0.1em;" id="info-marquee" class="col s12 card">
        <div class="">
          <?php if(count($updateInfo) > 0): ?>
            <ul id="marquee" class="marquee collection">
            <?php foreach ($updateInfo as $key => $row):?>
              <li class="dismissable">
                <a href="#menu-section">
                  <?='【'.$row->created->nice().'】'.$row['content']?>
                </a>
              </li>
            <?php endforeach ?>
            </ul>
          <?php else: ?>
            <ul id="marquee" class="marquee collection">
              <li class="dismissable">
                <a href="#!" class="">
                  最近の更新はありません…。
                </a>
              </li>
            </ul>
          <?php endif; ?>
        </div>
      </div>
      <?php endif; ?>

  </div>
</div>