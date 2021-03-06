<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    /**
     * Class Test
     */
    class Acknowledge_post_model extends Model
    {
        /**
         * @var string
         */
        protected $table = 'acknowledge_post';

        /**
         * @var string
         */
        protected $primaryKey = 'id';

        /**
         * @var bool
         */
        public $incrementing = TRUE;

        /**
         * @var string
         */
        protected $keyType = 'int';

        /**
         * @var bool
         */
        public $timestamps = TRUE;

        /**
         * Gets the user who created the event.
         *
         * @return BelongsTo
         */
        public function user()
        {
            return $this->belongsTo('User_model');
        }
    }
