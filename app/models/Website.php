<?php
class Website extends Model {
    protected string $table = 'websites';
    protected bool $softDelete = true;
    protected array $fillable = ['user_id','name','description','url','email','credentials','category','status','owner','notes','screenshot','ssl_expiry','domain_expiry','deleted_at'];

    public function setCredentials(int $id, string $plaintext): void {
        $this->update($id, ['credentials' => encrypt($plaintext)]);
    }
    public function getCredentials(int $id): ?string {
        $site = $this->find($id);
        return $site && $site['credentials'] ? decrypt($site['credentials']) : null;
    }
}
