<?php
require_once('DBConnection.class.php');


class functions extends DBConnection {

    public function getUserFullbane($userId){
        $sqlStatement = "SELECT fullname FROM users WHERE userid = ?";
        $result = $this->doQuery($sqlStatement, $userId);
        return $result;
    }
    public function getArticles($userId)
    {
        $query = "SELECT article.title, users.fullname, article.id FROM article INNER JOIN users ON article.userid = users.userid";
        $result = $this->doQuery($query);
        return $result;
    }
    public function getArticlesId($articleId)
    {
        $query = "SELECT * FROM article WHERE id = ?";
        $result = $this->doQuery($query, [$articleId]);
        return $result;
    }

    public function updateArticle($articleId, $title, $content)
    {
        $query = "UPDATE article SET id = ? , title = ? ,content = ? WHERE id = $articleId";
        $result = $this->doQuery($query, [$articleId, $title, $content]);
        return $result;
    }
}