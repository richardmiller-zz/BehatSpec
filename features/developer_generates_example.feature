Feature: Developer generates an example
  As a Developer
  I want to automate creating examples for methods
  In order to avoid repetitive tasks and interruptions in development flow

  Scenario: Generating an example
    Given the spec file "spec/CodeGeneration/MethodExample1/MarkdownSpec.php" contains:
      """
      <?php

      namespace spec\CodeGeneration\MethodExample1;

      use PhpSpec\ObjectBehavior;
      use Prophecy\Argument;

      class MarkdownSpec extends ObjectBehavior
      {
      }

      """
    When I run phpspec exemplify to add the "toHtml" method to "CodeGeneration/MethodExample1/Markdown"
    Then the spec file "spec/CodeGeneration/MethodExample1/MarkdownSpec.php" should contain:
      """
      <?php

      namespace spec\CodeGeneration\MethodExample1;

      use PhpSpec\ObjectBehavior;
      use Prophecy\Argument;

      class MarkdownSpec extends ObjectBehavior
      {

          public function it_should_to_html()
          {
              $this->toHtml();
          }
      }

      """

  Scenario: Trying to generate an example for a method already described
    Given the spec file "spec/CodeGeneration/MethodExample2/MarkdownSpec.php" contains:
      """
      <?php

      namespace spec\CodeGeneration\MethodExample2;

      use PhpSpec\ObjectBehavior;
      use Prophecy\Argument;

      class MarkdownSpec extends ObjectBehavior
      {
          function it_converts_plain_text_to_html_paragraphs()
          {
              $this->toHtml('Hi, there')->shouldReturn('<p>Hi, there</p>');
          }
      }

      """
    When I run phpspec exemplify to add the "toHtml" method to "CodeGeneration/MethodExample2/Markdown"
    Then the spec file "spec/CodeGeneration/MethodExample2/MarkdownSpec.php" should contain:
      """
      <?php

      namespace spec\CodeGeneration\MethodExample2;

      use PhpSpec\ObjectBehavior;
      use Prophecy\Argument;

      class MarkdownSpec extends ObjectBehavior
      {
          function it_converts_plain_text_to_html_paragraphs()
          {
              $this->toHtml('Hi, there')->shouldReturn('<p>Hi, there</p>');
          }
      }

      """
    And I should see "Example for Method CodeGeneration\MethodExample2\Markdown::toHtml() already exists. Try the phpspec run command"

  Scenario: Generating an example of a named constructor
    Given the spec file "spec/CodeGeneration/MethodExample3/MarkdownSpec.php" contains:
      """
      <?php

      namespace spec\CodeGeneration\MethodExample3;

      use PhpSpec\ObjectBehavior;
      use Prophecy\Argument;

      class MarkdownSpec extends ObjectBehavior
      {
      }

      """
    When I run phpspec exemplify to add the "fromMarkdown" method as a "named constructor" to "CodeGeneration/MethodExample3/Markdown"
    Then the spec file "spec/CodeGeneration/MethodExample3/MarkdownSpec.php" should contain:
      """
      <?php

      namespace spec\CodeGeneration\MethodExample3;

      use PhpSpec\ObjectBehavior;
      use Prophecy\Argument;

      class MarkdownSpec extends ObjectBehavior
      {

          public function it_should_be_constructed_through_from_markdown()
          {
              $this->beConstructedThrough('fromMarkdown');
          }
      }

      """

  Scenario: Generating an example of a static method
    Given the spec file "spec/CodeGeneration/MethodExample4/MarkdownSpec.php" contains:
      """
      <?php

      namespace spec\CodeGeneration\MethodExample4;

      use PhpSpec\ObjectBehavior;
      use Prophecy\Argument;

      class MarkdownSpec extends ObjectBehavior
      {
      }

      """
    When I run phpspec exemplify to add the "toHtml" method as a "static method" to "CodeGeneration/MethodExample4/Markdown"
    Then the spec file "spec/CodeGeneration/MethodExample4/MarkdownSpec.php" should contain:
      """
      <?php

      namespace spec\CodeGeneration\MethodExample4;

      use PhpSpec\ObjectBehavior;
      use Prophecy\Argument;

      class MarkdownSpec extends ObjectBehavior
      {

          public function it_should_to_html()
          {
              $this::toHtml();
          }
      }

      """

  Scenario: Trying to generate an example for a static method already described
    Given the spec file "spec/CodeGeneration/MethodExample5/MarkdownSpec.php" contains:
      """
      <?php

      namespace spec\CodeGeneration\MethodExample5;

      use PhpSpec\ObjectBehavior;
      use Prophecy\Argument;

      class MarkdownSpec extends ObjectBehavior
      {
          function it_converts_plain_text_to_html_paragraphs()
          {
              $this::toHtml('Hi, there')->shouldReturn('<p>Hi, there</p>');
          }
      }

      """
    When I run phpspec exemplify to add the "toHtml" method to "CodeGeneration/MethodExample5/Markdown"
    Then the spec file "spec/CodeGeneration/MethodExample5/MarkdownSpec.php" should contain:
      """
      <?php

      namespace spec\CodeGeneration\MethodExample5;

      use PhpSpec\ObjectBehavior;
      use Prophecy\Argument;

      class MarkdownSpec extends ObjectBehavior
      {
          function it_converts_plain_text_to_html_paragraphs()
          {
              $this::toHtml('Hi, there')->shouldReturn('<p>Hi, there</p>');
          }
      }

      """
    And I should see "Example for Method CodeGeneration\MethodExample5\Markdown::toHtml() already exists. Try the phpspec run command"

  Scenario: Trying to generate an example for a method already described as a named constructor
    Given the spec file "spec/CodeGeneration/MethodExample6/MarkdownSpec.php" contains:
      """
      <?php

      namespace spec\CodeGeneration\MethodExample6;

      use PhpSpec\ObjectBehavior;
      use Prophecy\Argument;

      class MarkdownSpec extends ObjectBehavior
      {
          function let()
          {
              $this->beConstructedThrough('fromMarkdown', ['blah']);
          }
      }

      """
    When I run phpspec exemplify to add the "fromMarkdown" method to "CodeGeneration/MethodExample6/Markdown"
    Then the spec file "spec/CodeGeneration/MethodExample6/MarkdownSpec.php" should contain:
      """
      <?php

      namespace spec\CodeGeneration\MethodExample6;

      use PhpSpec\ObjectBehavior;
      use Prophecy\Argument;

      class MarkdownSpec extends ObjectBehavior
      {
          function let()
          {
              $this->beConstructedThrough('fromMarkdown', ['blah']);
          }
      }

      """
    And I should see "Example for Method CodeGeneration\MethodExample6\Markdown::fromMarkdown() already exists. Try the phpspec run command"
