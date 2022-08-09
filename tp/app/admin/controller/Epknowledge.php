<?php
declare (strict_types=1);

namespace app\admin\controller;

use app\BaseController;
use think\Request;

class Epknowledge extends BaseController
{
    public function findall()
    {
        $title = $this->request->route('title');
        $result = GovAndEpk::search(0, $title);
        return json($result);
    }

    public function edit()
    {
        $data = $this->request->put();
        $result = GovAndEpk::edit(0, $data);
        return json($result);
    }

    public function add()
    {
        $data = $this->request->post();
        $result = GovAndEpk::add(0, $data);
        return json($result);
    }

    public function delete()
    {
        $id = $this->request->delete('id');
        $result = GovAndEpk::delete(0, $id);
        return json($result);
    }
}
