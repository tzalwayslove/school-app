__template__

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class {{ $model }} extends Model
{
    protected $table = '{{ strtolower($model) }}';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    use SoftDeletes;

    @foreach($col as $v)
        @if($v['type'] == 'select' && $v['from_table'] && $v['f_name'])
    public function {{ strtolower($v['from_table'].'_'.$v['f_name']) }}()
    {
        return $this->belongsTo('App\Model\{{ ucfirst($v['from_table']) }}', '{{ $v['col'] }}', 'id');
    }
            @endif
    @endforeach

}
