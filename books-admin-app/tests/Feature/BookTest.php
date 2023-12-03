<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * テスト名について
     * ・接頭辞にtest_をつける
     * ・@testをつける。メソッド名にtestは不要
     * ・日本語名でも大丈夫
     * test_<url>_<証明する内容>
     */

    
    
    
    //ログインしてないユーザーがbook.indexにアクセスできないこと（302）
    public function test_book_index_ng()
    {
        $response = $this->get('/book');
        $response->assertStatus(302);
    }
    
    
    //ログインユーザーがbook.indexにアクセスできること（200）
    public function test_book_index_ok()
    {   
        //ログインさせる場合は、factoryでuserを作り、actingAsでリクエストする。
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/book');
        $response->assertStatus(200);
    }

    //存在するIDでbook.detailにアクセスできることを確認（200）
    public function test_book_detail_id_exist()
    {   
        //ログインさせる場合は、factoryでuserを作り、actingAsでリクエストする。
        $user = User::factory()->create();
        $book = Book::factory()->create();
        
        $response = $this->actingAs($user)->get("/book/detail/$book->id");
        $response->assertStatus(200);
    }
    
    //存在しないIDでbook.detailにアクセスできないことを確認
    public function test_book_detail_id_not_exist()
    {   
        //ログインさせる場合は、factoryでuserを作り、actingAsでリクエストする。
        $user = User::factory()->create();
        // $book = Book::factory()->create();
        
        $response = $this->actingAs($user)->get("/book/detail/9999");
        $response->assertStatus(404);
    }
    
    //存在するIDでbook.editにアクセスできることを確認（200）
    public function test_book_edit_id_exist()
    {   
        //ログインさせる場合は、factoryでuserを作り、actingAsでリクエストする。
        $user = User::factory()->create();
        $book = Book::factory()->create();
        
        $response = $this->actingAs($user)->get("/book/edit/$book->id");
        $response->assertStatus(200);
    }

    //存在しないIDでbook.editにアクセスできないことを確認
    public function test_book_edit_id_not_exist()
    {   
        //ログインさせる場合は、factoryでuserを作り、actingAsでリクエストする。
        $user = User::factory()->create();
        // $book = Book::factory()->create();
        
        $response = $this->actingAs($user)->get("/book/edit/9999");
        $response->assertStatus(404);
    }

    //book.editで更新処理が正常に行えること
    public function test_book_update_ok()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $params = [
            'id' => $book->id,
            'name' => 'test',
            'status' => 1,
            'author' => 'test',
            'publication' => 'test',
            'read_at' => '2022-10-01',
            'note' => 'test',
        ];

        $response = $this->actingAs($user)->patch("/book/update", $params);
        $response->assertStatus(302);
        $response->assertSessionHas('status', '本を更新しました。');
        $this->assertDatabaseHas('books', $params);
    }
    
    //不正な値でbook.editで更新処理がエラーになること
    public function test_book_update_ng()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $params = [
            'id' => $book->id,
            'name' => 'test',
            'status' => 9,
            'author' => 'test',
            'publication' => 'test',
            'read_at' => '2022-10-01',
            'note' => 'test',
        ];

        $response = $this->actingAs($user)->patch("/book/update", $params);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['status' => '選択されたステータスは、有効ではありません。']);
        $this->assertDatabaseMissing('books', $params); //dbの値が更新されてないこと
    }
}

        //book.newで更新処理が正常に行えること
        //不正な値でbook.newで更新処理がエラーになること
        //book.removeで更新処理が正常に行えること
        //不正な値でbook.removeで更新処理がエラーになること
        //検索が正常に行えること