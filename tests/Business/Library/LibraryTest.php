<?php

namespace App\Tests\Library;

use App\Business\Library\Article;
use App\Business\Library\Library;
use PHPUnit\Framework\TestCase;

class LibraryTest extends TestCase
{
    public function testCreateEmpty()
    {
        $lib = Library::createEmpty('idLib');

        $this->assertGreaterThan(1, mb_strlen($lib->getId()));
        $this->assertNull($lib->getName());
        $this->assertNull($lib->getDescription());
        $this->assertNull($lib->getParent());
        $this->assertCount(0, $lib->getChildren());
    }

    public function testCreateWithDescription()
    {
        $lib = Library::create('idLib', 'name', 'description');

        $this->assertGreaterThan(1, mb_strlen($lib->getId()));
        $this->assertEquals('name', $lib->getName());
        $this->assertEquals('description', $lib->getDescription());
        $this->assertNull($lib->getParent());
        $this->assertCount(0, $lib->getChildren());
    }

    public function testCreateWithoutDescription()
    {
        $lib = Library::create('idLib', 'name');

        $this->assertGreaterThan(1, mb_strlen($lib->getId()));
        $this->assertEquals('name', $lib->getName());
        $this->assertNull($lib->getDescription());
        $this->assertNull($lib->getParent());
        $this->assertCount(0, $lib->getChildren());
    }

    public function testRename()
    {
        $lib = Library::create('idLib', 'old name');

        $lib->rename('new name');

        $this->assertEquals('new name', $lib->getName());
        $this->assertNull($lib->getDescription());
    }

    public function testChangeDescription()
    {
        $lib = Library::create('idLib', 'old name', 'old description');

        $lib->changeDescription('new description');

        $this->assertEquals('old name', $lib->getName());
        $this->assertEquals('new description', $lib->getDescription());
    }

    public function testChangeParentFromNull()
    {
        $lib = Library::createEmpty('idLib');

        $parent = Library::createEmpty('idLib');

        $lib->changeParent($parent);

        $this->assertEquals($parent, $lib->getParent());
        $this->assertCount(1, $parent->getChildren());
    }

    public function testChangeParentFromExist()
    {
        $lib = Library::createEmpty('idLib');

        $oldParent = Library::createEmpty('idLib');
        $lib->changeParent($oldParent);

        $newParent = Library::createEmpty('idLib');

        $lib->changeParent($newParent);

        $this->assertEquals($newParent, $lib->getParent());
        $this->assertCount(0, $oldParent->getChildren());
        $this->assertCount(1, $newParent->getChildren());
    }

    public function testOrphan()
    {
        $lib = Library::createEmpty('idLib');

        $parent = Library::createEmpty('idLib');
        $lib->changeParent($parent);

        $lib->orphan();

        $this->assertCount(0, $parent->getChildren());
        $this->assertNull($lib->getParent());
    }

    public function testAddOrphanChild()
    {
        $lib = Library::createEmpty('idLib');

        $child = Library::createEmpty('idLib');

        $lib->addChild($child);

        $this->assertCount(1, $lib->getChildren());
        $this->assertEquals($lib, $child->getParent());
    }

    public function testAddChildWithExistParent()
    {
        $lib = Library::createEmpty('idLib');

        $child = Library::createEmpty('idLib');
        $oldParent = Library::createEmpty('idLib');
        $child->changeParent($oldParent);

        $lib->addChild($child);

        $this->assertEquals($lib, $child->getParent());
        $this->assertCount(1, $lib->getChildren());
        $this->assertCount(0, $oldParent->getChildren());
    }

    public function testRemoveChild()
    {
        $lib = Library::createEmpty('idLib');

        $child = Library::createEmpty('idLib');
        $lib->addChild($child);

        $lib->removeChild($child);

        $this->assertNull($child->getParent());
        $this->assertCount(0, $lib->getChildren());
    }

    public function testAddOrphanArticle()
    {
        $lib = Library::createEmpty('idLib');

        $article = Article::createEmpty('id1');

        $lib->addArticle($article);

        $this->assertCount(1, $lib->getArticles());
        $this->assertEquals($lib, $article->getLibrary());
    }

    public function testAddArticleFromOtherLibrary()
    {
        $lib = Library::createEmpty('idLib');

        $oldLibrary = Library::createEmpty('idLib');
        $article = Article::createEmpty('id1');
        $oldLibrary->addArticle($article);

        $lib->addArticle($article);

        $this->assertCount(1, $lib->getArticles());
        $this->assertEquals($lib, $article->getLibrary());
        $this->assertCount(0, $oldLibrary->getArticles());
    }

    public function testRemoveArticle()
    {
        $lib = Library::createEmpty('idLib');

        $article = Article::createEmpty('id1');
        $lib->addArticle($article);

        $lib->removeArticle($article);

        $this->assertNull($article->getLibrary());
        $this->assertCount(0, $lib->getArticles());
    }
}
