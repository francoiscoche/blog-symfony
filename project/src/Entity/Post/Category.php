<?php

namespace App\Entity\Post;

use App\Entity\Trait\CategoryTagTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Post\CategoryRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('slug', message: 'This slug already exist.')]
class Category
{

    use CategoryTagTrait;


    #[ORM\ManyToMany(targetEntity: Post::class, inversedBy: 'categories')]
    private Collection $posts;

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        $this->posts->removeElement($post);

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
