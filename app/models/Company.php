<?php
class Company extends Model {
    protected string $table = 'company_info';
    protected bool $softDelete = false;
    protected array $fillable = ['user_id','name','manager','type','phone','email','address','capital','employees','registration_number','tax_id','website','logo','description','notes'];

    public function getByUser(int $userId): ?array {
        return $this->findWhere(['user_id' => $userId]);
    }
}
