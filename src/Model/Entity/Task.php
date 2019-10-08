<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Task Entity
 *
 * @property int $id
 * @property string $name
 * @property int $is_complete
 * @property \Cake\I18n\FrozenTime|null $completed
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class Task extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'is_complete' => true,
        'completed' => true,
        'created' => true,
        'modified' => true
    ];

    /**
     * Virtual fields to be included when the entity is cast to json
     *
     * @var array
     */
    protected $_virtual = [
        'completed_ago_in_words',
        'created_nice',
        'modified_nice'
    ];

    /**
     * Return a formatted time ago in words when the task was completed
     *
     * @return string|null
     */
    protected function _getCompletedAgoInWords(): ?string
    {
        if ($this->get('completed') !== null) {
            return $this->get('completed')->timeAgoInWords();
        }

        return null;
    }

    /**
     * Return a nicely formatted datetime string
     *
     * @return string|null
     */
    protected function _getCreatedNice(): ?string
    {
        if ($this->get('created') !== null) {
            return $this->get('created')->nice();
        }

        return null;
    }

    /**
     * Return a nicely formatted datetime string
     *
     * @return string|null
     */
    protected function _getModifiedNice(): ?string
    {
        if ($this->get('modified') !== null) {
            return $this->get('modified')->nice();
        }

        return null;
    }
}
