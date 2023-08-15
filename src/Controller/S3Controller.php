<?php

namespace App\Controller;

use Aws\Result;
use RuntimeException;
use App\Controller\AppController;

/**
 * S3 Controller
 *
 *
 * @method \App\Model\Entity\S3[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class S3Controller extends AppController {
    protected $s3Backet;

    // /**
    //  * Index method
    //  *
    //  * @return \Cake\Http\Response|null
    //  */
    // public function index()
    // {
    //     $s3 = $this->paginate($this->S3);

    //     $this->set(compact('s3'));
    // }

    // /**
    //  * View method
    //  *
    //  * @param string|null $id S3 id.
    //  * @return \Cake\Http\Response|null
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function view($id = null)
    // {
    //     $s3 = $this->S3->get($id, [
    //         'contain' => [],
    //     ]);

    //     $this->set('s3', $s3);
    // }

    // /**
    //  * Add method
    //  *
    //  * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
    //  */
    // public function add()
    // {
    //     $s3 = $this->S3->newEntity();
    //     if ($this->request->is('post')) {
    //         $s3 = $this->S3->patchEntity($s3, $this->request->getData());
    //         if ($this->S3->save($s3)) {
    //             $this->Flash->success(__('The s3 has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The s3 could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('s3'));
    // }

    // /**
    //  * Edit method
    //  *
    //  * @param string|null $id S3 id.
    //  * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function edit($id = null)
    // {
    //     $s3 = $this->S3->get($id, [
    //         'contain' => [],
    //     ]);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $s3 = $this->S3->patchEntity($s3, $this->request->getData());
    //         if ($this->S3->save($s3)) {
    //             $this->Flash->success(__('The s3 has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The s3 could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('s3'));
    // }

    // /**
    //  * Delete method
    //  *
    //  * @param string|null $id S3 id.
    //  * @return \Cake\Http\Response|null Redirects to index.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $s3 = $this->S3->get($id);
    //     if ($this->S3->delete($s3)) {
    //         $this->Flash->success(__('The s3 has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The s3 could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }

    public function initialize() {
        parent::initialize();
        $this->loadComponent('S3Client');
        $this->autoRender = false;

        $this->s3Backet = env('AWS_URL') . env('AWS_BUCKET');
    }

    public function getList() {
        $file_list = $this->S3Client->getList(null);
        print_r($file_list);
        exit;
    }

    public function upload($key, $tmpName, $bucketName = null) {
        $option = [
            'Bucket'     => '',
            'Key'        => $key,
            'SourceFile' => $tmpName,
        ];

        $result = $this->S3Client->putFile($option, $bucketName);
        if ($result instanceof Result) {
            return $result;
        } else {
            throw new RuntimeException($result);
        }
    }

    public function download($fineName) {
        $file_name = $fineName;
        $s3_dir = "";
        $store_dir = sprintf('%s/d', $this->s3Backet);

        $s3_file_path = sprintf('%s%s', $s3_dir, $file_name);
        $store_file_path = sprintf('%s/%s', $store_dir, $file_name);

        $file = $this->S3Client->getFile($s3_file_path, $store_file_path);
        return $file;
    }

    public function downloadDirectory() {
        $s3_dir = "cp";
        $local_dir = "dl";
        $local_dir_path = sprintf('%s/%s', $this->s3Backet, $local_dir);
        $this->S3Client->getDirectory($s3_dir, $local_dir_path);
    }

    public function copy() {
        $file_name = "test.png";
        $s3_dir = "";
        $s3_copy_dir = "cp/";

        $s3_file_path = sprintf('%s%s', $s3_dir, $file_name);
        $s3_copy_file_path = sprintf('%s%s', $s3_copy_dir, $file_name);

        $this->S3Client->copyFile($s3_file_path, $s3_copy_file_path);
    }

    public function copyDirectory() {
        $s3_from_dir = "cp";
        $s3_to_dir = "cp_d";
        $this->S3Client->copyDirectory($s3_from_dir, $s3_to_dir);
    }

    public function move() {
        $file_name = "test.png";
        $s3_from_dir = "cp/";
        $s3_to_dir = "mv/";
        $s3_from_path = sprintf('%s%s', $s3_from_dir, $file_name);
        $s3_to_path = sprintf('%s%s', $s3_to_dir, $file_name);
        $this->S3Client->moveFile($s3_from_path, $s3_to_path);
    }

    public function moveDirectory() {
        $s3_from_dir = "mv";
        $s3_to_dir = "mv_d";
        $this->S3Client->moveDirectory($s3_from_dir, $s3_to_dir);
    }

    public function delete($key) {
        $s3_file_path = $key;
        $result = $this->S3Client->deleteFile($s3_file_path);
        if ($result instanceof Result) {
            try {
                // 削除チェック
                $this->S3Client->getFile($s3_file_path);
                throw new RuntimeException('画像の削除ができませんでした。');
            } catch (RuntimeException $e) {
                // 例外発生なら削除されて存在しないことになるのでOK！
                return $result;
            }
        } else {
            throw new RuntimeException($result);
        }
    }

    public function deleteDirectory($dirPath) {
        $s3_file_path = $dirPath;
        $result = $this->S3Client->deleteDirectory($s3_file_path);
        if ($result instanceof Result) {
            // 削除チェック
            $listObjects = $this->S3Client->getListObjects(null, $s3_file_path, 1);
            if (!is_null($listObjects['Contents'])) {
                throw new RuntimeException('画像の削除ができませんでした。');
            }
        } else {
            throw new RuntimeException($result);
        }
    }
}
