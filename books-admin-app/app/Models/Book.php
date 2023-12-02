<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];

    
    public const BOOK_STATUS_READING = 1;
    public const BOOK_STATUS_UNREAD= 2;
    public const BOOK_STATUS_DONE = 3;
    public const BOOK_STATUS_WANT_READ = 4;

    public const BOOK_STATUS_NAME_READING = '読書中';
    public const BOOK_STATUS_NAME_UNREAD = '未読';
    public const BOOK_STATUS_NAME_DONE = '読破';
    public const BOOK_STATUS_NAME_WANT_READ = '読みたい';

    public const BOOK_STATUS_OBJECT = [
        self::BOOK_STATUS_READING => self::BOOK_STATUS_NAME_READING,
        self::BOOK_STATUS_UNREAD => self::BOOK_STATUS_NAME_UNREAD,
        self::BOOK_STATUS_DONE => self::BOOK_STATUS_NAME_DONE,
        self::BOOK_STATUS_WANT_READ => self::BOOK_STATUS_NAME_WANT_READ,
    ];

    public const BOOK_STATUS_ARRAY = [
        self::BOOK_STATUS_READING,
        self::BOOK_STATUS_UNREAD,
        self::BOOK_STATUS_DONE,
        self::BOOK_STATUS_WANT_READ,
    ];

    // scope
    // グルーバルスコープ：モデルを利用する際に、毎回呼び出されるスコープ（where文とかのquery関数）
    // ローカルスコープ：スコープを利用したい場合に、自身で都度呼び出すスコープ
    // scopeは利用する際に含まない。大文字小文字もどちらでもOK! Book::search();

    public function scopeSearch($query, $search)
    {   
        $name = $search['name'] ?? '';
        $status = $search['status'] ?? '';
        $author = $search['author'] ?? '';
        $publication = $search['publication'] ?? '';
        $note = $search['note'] ?? '';


        $query->when($name, function ($query, $name) {
            $query->where('name', 'like', "%$name%");
        });

        $query->when($author, function ($query, $author) {
            $query->where('author', $author);
        });

        $query->when($publication, function ($query, $publication) {
            $query->where('publication', $publication);
        });

        $query->when($note, function ($query, $note) {
            $query->where('note', 'like', "%$note%");
        });

        $query->when($status, function ($query, $status) {
            $query->where('status', $status);
        });

        return $query;
    }
}
