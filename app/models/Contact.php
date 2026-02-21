<?php
class Contact extends Model {
    protected string $table = 'contacts';
    protected bool $softDelete = true;
    protected array $fillable = ['user_id','first_name','last_name','email','phone','company','position','address','tags','notes','avatar','deleted_at'];

    public function searchContacts(int $userId, string $term): array {
        return $this->raw(
            "SELECT * FROM contacts WHERE user_id = :uid AND deleted_at IS NULL AND (first_name LIKE :t OR last_name LIKE :t2 OR email LIKE :t3 OR company LIKE :t4 OR tags LIKE :t5) ORDER BY first_name ASC LIMIT 50",
            ['uid'=>$userId,'t'=>"%{$term}%",'t2'=>"%{$term}%",'t3'=>"%{$term}%",'t4'=>"%{$term}%",'t5'=>"%{$term}%"]
        );
    }

    public function getInteractions(int $contactId): array {
        return $this->raw("SELECT * FROM contact_interactions WHERE contact_id = :cid ORDER BY interaction_date DESC", ['cid' => $contactId]);
    }

    public function addInteraction(array $data): void {
        $this->rawExecute("INSERT INTO contact_interactions (contact_id, user_id, type, description, interaction_date, created_at) VALUES (:cid, :uid, :type, :desc, :date, NOW())",
            ['cid'=>$data['contact_id'],'uid'=>$data['user_id'],'type'=>$data['type'],'desc'=>$data['description'],'date'=>$data['interaction_date']??date('Y-m-d H:i:s')]);
    }

    public function exportCsv(int $userId): string {
        $contacts = $this->where(['user_id' => $userId], 'first_name', 'ASC');
        $csv = "Prénom,Nom,Email,Téléphone,Entreprise,Poste,Tags\n";
        foreach ($contacts as $c) {
            $csv .= '"'.str_replace('"','""',$c['first_name']).'","'.str_replace('"','""',$c['last_name']??'').'","'.($c['email']??'').'","'.($c['phone']??'').'","'.str_replace('"','""',$c['company']??'').'","'.str_replace('"','""',$c['position']??'').'","'.($c['tags']??'').'"'."\n";
        }
        return $csv;
    }
}
