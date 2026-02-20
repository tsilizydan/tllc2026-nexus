<?php
class Note extends Model {
    protected string $table = 'notes';
    protected bool $softDelete = true;
    protected array $fillable = ['user_id','parent_id','title','content','icon','sort_order','is_pinned','deleted_at'];

    public function getTree(int $userId): array {
        $all = $this->where(['user_id' => $userId], 'sort_order', 'ASC');
        return $this->buildTree($all, null);
    }

    private function buildTree(array $items, ?int $parentId): array {
        $tree = [];
        foreach ($items as $item) {
            if ($item['parent_id'] == $parentId) {
                $item['children'] = $this->buildTree($items, $item['id']);
                $tree[] = $item;
            }
        }
        return $tree;
    }

    public function saveVersion(int $noteId, string $content): void {
        $this->rawExecute("INSERT INTO note_versions (note_id, content, created_at) VALUES (:nid, :content, NOW())", ['nid' => $noteId, 'content' => $content]);
    }

    public function getVersions(int $noteId): array {
        return $this->raw("SELECT * FROM note_versions WHERE note_id = :nid ORDER BY created_at DESC LIMIT 20", ['nid' => $noteId]);
    }
}
