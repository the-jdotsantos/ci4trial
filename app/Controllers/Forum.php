<?php

namespace App\Controllers;
use App\Models\PostModel;

class Forum extends BaseController
{
    public function index()
    {
        $model = new PostModel();
        $data['posts'] = $model->orderBy('created_at', 'DESC')->findAll();
        return view('forum/index', $data);
    }

    public function create()
    {
        return view('forum/create');
    }

 public function store()
{
    $model = new PostModel();

    $authorName = session()->get('logged_in') 
        ? session()->get('username') 
        : $this->request->getPost('author_name');

    $data = [
        'author_name' => $authorName,
        'title'       => $this->request->getPost('title'),
        'content'     => $this->request->getPost('content'),
    ];

    $model->insert($data);
    return redirect()->to('/forum');
}


public function edit($id)
{
    $model = new PostModel();
    $post = $model->find($id);

//exclusive editing
    if (!session()->get('logged_in') || session()->get('username') !== $post['author_name']) {
        return redirect()->to('/forum')->with('error', 'Unauthorized');
    }

    return view('forum/edit', ['post' => $post]);
}


                    public function update($id)
                    {
                        $model = new PostModel();
                        $model->update($id, [
                            'author_name' => $this->request->getPost('author_name'),
                            'title'       => $this->request->getPost('title'),
                            'content'     => $this->request->getPost('content'),
                        ]);
                        return redirect()->to('/forum');
                    }
 
    
}
