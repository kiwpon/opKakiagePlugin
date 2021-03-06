<?php

/**
 * PluginKakiageTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PluginKakiageTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object PluginKakiageTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('PluginKakiage');
  }

  public function getWeekly($memberId)
  {
    return $this->createQuery()
      ->where('member_id = ?', $memberId)
      ->andWhere('target_date <= ?', date('Y-m-d'))
      ->andWhere('target_date > ?', date('Y-m-d', strtotime('-1 week -1 day')))
      ->orderBy('target_date')
      ->execute();
  }

  public function getRecently($memberId, $count = null)
  {
    if (null === $count)
    {
      $count = 7;
    }
    $ret = $this->createQuery()
      ->where('member_id = ?', $memberId)
      ->orderBy('target_date DESC')
      ->limit($count)
      ->execute();

    $ary = array();
    foreach ($ret as $key => $val)
    {
      $ary[] = array($key, $val);
    }

    $res = array();
    $len = count($ary);
    for ($i = 0; $i < $len; ++$i)
    {
      $k = $len - $i - 1;
      $res[$ary[$k][0]] = $ary[$k][1];
    }
    return $res;
  }

  public function getPrevious($memberId, $date)
  {
    return $this->createQuery()
      ->where('member_id = ?', $memberId)
      ->andWhere('target_date < ?', $date)
      ->orderBy('target_date DESC')
      ->limit(1)
      ->fetchOne();
  }
}
