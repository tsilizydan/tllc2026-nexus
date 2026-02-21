<?php
class SearchController extends Controller {
    public function index(): void {
        $this->requireAuth();
        $q = $this->query('q', '');
        $results = [];

        if (strlen($q) >= 2) {
            $uid = Auth::id();
            $safeQ = strip_tags(trim($q));

            $results['tasks'] = (new Task())->search($safeQ, ['title', 'description']);
            $results['tasks'] = array_filter($results['tasks'], fn($t) => $t['user_id'] == $uid);

            $results['notes'] = (new Note())->search($safeQ, ['title', 'content']);
            $results['notes'] = array_filter($results['notes'], fn($n) => $n['user_id'] == $uid);

            $results['contacts'] = (new Contact())->searchContacts($uid, $safeQ);

            $results['projects'] = (new Project())->search($safeQ, ['name', 'description']);
            $results['projects'] = array_filter($results['projects'], fn($p) => $p['user_id'] == $uid);
        }

        $this->view('search.index', ['pageTitle' => 'Recherche', 'query' => $q, 'results' => $results]);
    }

    public function ajaxSearch(): void {
        $this->requireAuth();
        $q = $this->query('q', '');
        $results = [];

        if (strlen($q) >= 2) {
            $uid = Auth::id();
            $safeQ = strip_tags(trim($q));

            $tasks = (new Task())->search($safeQ, ['title']);
            $tasks = array_filter($tasks, fn($t) => $t['user_id'] == $uid);
            foreach (array_slice(array_values($tasks), 0, 5) as $t) {
                $results[] = ['type' => 'task', 'title' => $t['title'], 'url' => url('/tasks/' . $t['id'])];
            }

            $notes = (new Note())->search($safeQ, ['title']);
            $notes = array_filter($notes, fn($n) => $n['user_id'] == $uid);
            foreach (array_slice(array_values($notes), 0, 5) as $n) {
                $results[] = ['type' => 'note', 'title' => $n['title'], 'url' => url('/notes/' . $n['id'])];
            }
        }

        $this->json($results);
    }
}
