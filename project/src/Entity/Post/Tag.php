<?php

namespace App\Entity\Post;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CategoryTagTrait;
use App\Repository\Post\TagRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('slug', message: 'This slug already exist.')]
class Tag
{
    use CategoryTagTrait;

    #[ORM\ManyToMany(targetEntity: Post::class, inversedBy: 'tags')]
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
        
        return $this->title;
    }
}