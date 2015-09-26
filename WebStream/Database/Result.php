<?php
namespace WebStream\Database;

use WebStream\Module\Logger;
use WebStream\Exception\Extend\CollectionException;

/**
 * Result
 * @author Ryuichi TANAKA.
 * @since 2013/12/14
 * @version 0.4
 */
class Result implements \Iterator, \SeekableIterator, \ArrayAccess, \Countable
{
    /** ステートメントオブジェクト */
    private $stmt;

    /** 列データ */
    private $row;

    /** キャッシュ化列データ */
    private $rowCache;

    /** インデックス位置 */
    private $position;

    /**
     * コンストラクタ
     * @param Doctrine\DBAL\Statement ステートメントオブジェクト
     */
    public function __construct(\Doctrine\DBAL\Statement $stmt)
    {
        $this->stmt = $stmt;
        $this->position = 0;
        $this->rowCache = [];
    }

    /**
     * デストラクタ
     */
    public function __destruct()
    {
        $this->stmt = null;
        $this->rowCache = null;
    }

    /**
     * Implements Countable#count
     * @return integer 結果件数
     */
    public function count()
    {
        $count = 0;
        if ($this->stmt === null) {
            $count = count($this->rowCache);
        } else {
            $count = $this->stmt->rowCount();
            if ($count === 0) {
                $this->toArray();
                $count = count($this->rowCache);
            }
        }

        return $count;
    }

    /**
     * Implements SeekableIterator#seek
     * カーソル位置を移動する
     * @param mixed オフセット
     */
    public function seek($offset)
    {
        if ($this->stmt !== null) {
            // Mysql does not support scrollable cursor.
            // but if statement to array, it is accessable.
            $this->toArray();
        }
        if (array_key_exists($offset, $this->rowCache)) {
            return $this->rowCache[$offset];
        } else {
            throw new \OutOfBoundsException("Current cursor is out of range: " . $offset);
        }
    }

    /**
     * Implements Iterator#current
     * 現在の要素を返却する
     * @return array<string> 列データ
     */
    public function current()
    {
        if ($this->stmt === null) {
            return array_key_exists($this->position, $this->rowCache) ? $this->rowCache[$this->position] : null;
        }

        return $this->row;
    }

    /**
     * Implements Iterator#key
     * 現在の要素のキーを返却する
     * @return integer キー
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Implements Iterator#next
     * 次の要素に進む
     */
    public function next()
    {
        if ($this->stmt !== null) {
            $this->row = $this->stmt->fetch(\PDO::FETCH_ASSOC);
        }
        $this->position++;
    }

    /**
     * Implements Iterator#rewind
     * イテレータを先頭に巻き戻す
     */
    public function rewind()
    {
        if ($this->stmt !== null) {
            $this->row = $this->stmt->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_FIRST);
        }
        $this->position = 0;
    }

    /**
     * Implements Iterator#valid
     * 現在位置が有効かどうかを調べる
     * @return boolean 有効かどうか
     */
    public function valid()
    {
        return $this->row !== false;
    }

    /**
     * Implements ArrayAccess#offsetExists
     * オフセットの位置に値が存在するかどうか返却する
     * @return boolean 値が存在するかどうか
     */
    public function offsetExists($offset)
    {
        if ($this->stmt !== null) {
            $this->toArray();
        }

        return array_key_exists($offset, $this->rowCache);
    }

    /**
     * Implements ArrayAccess#offsetGet
     * オフセットの位置の値を返却する
     * @return mixed 値
     */
    public function offsetGet($offset)
    {
        if ($this->stmt !== null) {
            $this->toArray();
        }

        return $this->rowCache[$offset];
    }

    /**
     * Implements ArrayAccess#offsetSet
     * オフセットの位置に値を設定する
     * @param mixed オフセット
     * @param mixed 値
     */
    public function offsetSet($offset, $value)
    {
        throw new CollectionException("Database results are read only.");
    }

    /**
     * Implements ArrayAccess#offsetUnSet
     * オフセットの設定を解除する
     * @param mixed オフセット
     */
    public function offsetUnSet($offset)
    {
        throw new CollectionException("Database results are read only.");
    }

    /**
     * 検索結果を全て配列として返却する
     * @return array<string> 検索結果
     */
    public function toArray()
    {
        $this->rowCache = $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
        Logger::debug("All results to array and cached.");
        $this->stmt = null;

        return $this->rowCache;
    }

    /**
     * 検索結果をエンティティとして返却する
     * @return object 検索結果
     */
    public function toEntity($classpath)
    {
        return new ResultEntity($this->stmt->getWrappedStatement(), $classpath);
    }
}
