<?php

namespace App\Models\Monitoring;

use App\Models\Master\OrangTua;
use App\Models\Master\Siswa;
use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ref\Doa as DoaRef;

class Doa extends Model
{
    use CreatedByTrait;

    protected $fillable = ['id_siswa', 'id_doa', 'lu', 'feedback', 'feedback_by', 'created_by'];

    protected $table = 'monitoring_doa';

    public $timestamps = false;

    public static function store($arg)
    {
        if (is_array($arg)) {
            $arg["created_at"] = date("Y-m-d H:i:s");
        }

        return static::insert($arg);
    }

    public function feedback_by()
    {
        if (!$this->feedback_by) {
            return null;
        }

        $orang_tua = OrangTua::find($this->feedback_by);
        if (!$orang_tua) {
            return null;
        }

        return $orang_tua->nama;
    }

    public function role() {
        if (!$this->created_by) {
            return null;
        }

        $user = User::find($this->created_by);

        if (!$user) {
            return null;
        }

        $roles = [
            'admin' => 'Admin',
            'guru' => 'Guru',
            'orang_tua' => 'Orang Tua'
        ];

        return $roles[$user->role] ?? null;
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function doa()
    {
        return DoaRef::find($this->id_doa);
    }
}
