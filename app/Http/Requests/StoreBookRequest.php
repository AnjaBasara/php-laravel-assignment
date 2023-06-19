<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $title
 * @property string $ISBN
 * @property int $publication_year
 * @property float $price
 * @property string $genre
 * @property string $subgenre
 * @property int $sort_order
 * @property int $stock_amount
 * @property int $writer_id
 * @property int $publisher_id
 */
class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'ISBN' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'genre' => 'required|string|max:255',
            'stock_amount' => 'required|integer|min:0',
            'subgenre' => 'required|string|max:255',
            'writer_id' => 'required|exists:writers,id',
            'publisher_id' => 'required|exists:publishers,id',
        ];
    }
}
