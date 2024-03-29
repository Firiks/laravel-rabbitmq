<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProductUpdated implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  private $data;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($data)
  {
    $this->data = $data;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $product = Product::findOrFail($this->data['id']);

    $product->update([
      'title' => $this->data['title'],
      'image' => $this->data['image'],
      'created_at' => $this->data['created_at'],
      'updated_at' => $this->data['updated_at'],
    ]);
  }
}
