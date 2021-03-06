<?php

namespace App\Models;

class User extends Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", length=10, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=255, nullable=false)
     */
    public $name;

    /**
     *
     * @var integer
     * @Column(column="role_id", type="integer", length=11, nullable=false)
     */
    public $role_id;

    /**
     *
     * @var string
     * @Column(column="created_at", type="string", nullable=true)
     */
    public $created_at;

    /**
     *
     * @var string
     * @Column(column="updated_at", type="string", nullable=true)
     */
    public $updated_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcon");
        $this->setSource("user");
        $this->hasMany('id', Book::class, 'uid', [
            'alias' => 'book',
        ]);
        $this->hasOne('role_id', Role::class, 'id', [
            'alias' => 'role',
        ]);
        $this->hasManyToMany(
            'id',
            UserTitle::class,
            'uid',
            'title_id',
            Title::class,
            'id',
            [
                'alias' => 'title',
                'reusable' => true,
            ]
        );
        parent::initialize();
    }

    public function reloadRelation()
    {
        if (!isset($this->id)) {
            throw new \Exception('User主键未知！');
        }

        $seeds = Seeds::getInstance($this->id);

        $this->hasMany('id', get_class($seeds), 'uid', [
            'alias' => 'seeds',
        ]);

        return $this;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]|User|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
}
