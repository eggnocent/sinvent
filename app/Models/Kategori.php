<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = ['deskripsi', 'kategori'];

    protected $appends = ['kategori_deskripsi'];

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }

    public static function search($query)
    {
        return self::where('deskripsi', 'LIKE', "%{$query}%")
            ->orWhere('kategori', 'LIKE', "%{$query}%")
            ->get();
    }

    // Accessor for kategori_deskripsi
    public function getKategoriDeskripsiAttribute()
    {
        $result = DB::selectOne('SELECT ketKategori(?) as kategori_deskripsi', [$this->kategori]);
        return $result ? $result->kategori_deskripsi : null;
    }
}
