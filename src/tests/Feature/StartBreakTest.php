<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Member;
use App\Models\WorkDate;
use App\Models\Breakk;
use Carbon\Carbon;
use Mockery;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartBreakTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_start_break()
    {
        // `SymfonyStyle`のモックを作成
        $inputMock = Mockery::mock(InputInterface::class);
        $outputMock = Mockery::mock(OutputInterface::class);
        $styleMock = Mockery::mock(SymfonyStyle::class, [$inputMock, $outputMock]);

        // `askQuestion` メソッドのモック設定
        $styleMock->shouldReceive('askQuestion')->andReturn(null);

        // ユーザーのログイン状態を設定
        $member = Member::factory()->create();
        $this->actingAs($member);

        // 事前に勤務データを作成
        $date = WorkDate::factory()->create([
            'member_id' => $member->id,
            'date' => Carbon::today()->toDateString(),
            'start_work' => Carbon::now(),
        ]);

        // 休憩開始のPOSTリクエストを送信
        $response = $this->post('/start-break');

        // ステータスコード302を確認（リダイレクト）
        $response->assertStatus(302);

        // データベースに休憩のレコードが挿入されたか確認
        $this->assertDatabaseHas('breakks', [
            'date_id' => $date->id,
        ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}


