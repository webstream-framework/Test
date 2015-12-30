<?php
namespace WebStream\Test;

// use WebStream\Module\Utility;
use WebStream\Log\Logger;

require_once dirname(__FILE__) . '/TestConstant.php';
require_once dirname(__FILE__) . '/../TestApp/vendor/autoload.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/Utility/CommonUtils.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/Utility/ApplicationUtils.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/Utility/FileUtils.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/Utility/LoggerUtils.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/Utility/SecurityUtils.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Base/IAnnotatable.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Log/Logger.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Log/LoggerAdapter.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Log/LoggerFormatter.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/Singleton.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/PropertyProxy.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/DI/ServiceLocator.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/DI/Injector.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/Cache.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/Container.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/Functions.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/HttpClient.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/Security.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/ValueProxy.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/ClassLoader.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Base/IClass.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Base/IMethod.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Base/IMethods.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Base/IProperty.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Base/IRead.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Base/Annotation.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Container/AnnotationContainer.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Container/AnnotationListContainer.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Container/ContainerFactory.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Reader/AnnotationReader.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Alias.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Autowired.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/CsrfProtection.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Database.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/ExceptionHandler.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Filter.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Header.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Query.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Template.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Annotation/Validate.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Database/DatabaseManager.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Database/ConnectionManager.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Database/EntityManager.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Database/Driver/DatabaseDriver.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Database/Driver/Mysql.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Database/Driver/Postgresql.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Database/Driver/Sqlite.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Database/Query.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Database/Result.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Database/ResultEntity.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Delegate/CoreDelegator.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Delegate/CoreExecuteDelegator.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Delegate/CoreExceptionDelegator.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Delegate/AnnotationDelegator.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Delegate/AnnotationDelegatorFactory.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Delegate/ExceptionDelegator.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Delegate/Resolver.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Delegate/Router.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Template/ITemplateEngine.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Template/Basic.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Template/Twig.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Validate/Rule/IValidate.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Validate/Rule/Equal.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Validate/Rule/Length.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Validate/Rule/Max.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Validate/Rule/MaxLength.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Validate/Rule/Min.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Validate/Rule/MinLength.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Validate/Rule/Number.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Validate/Rule/Range.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Validate/Rule/Regexp.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Validate/Rule/Required.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/ApplicationException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/SystemException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/DelegateException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/Extend/AnnotationException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/Extend/ClassNotFoundException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/Extend/IOException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/Extend/CollectionException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/Extend/CsrfException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/Extend/DatabaseException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/Extend/ForbiddenAccessException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/Extend/InvalidArgumentException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/Extend/InvalidRequestException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/Extend/LoggerException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/Extend/MethodNotFoundException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/Extend/OutOfBoundsException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/Extend/ResourceNotFoundException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/Extend/RouterException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/Extend/SessionTimeoutException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/Extend/ValidateException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Http/Method/MethodInterface.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Http/Method/Get.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Http/Method/Post.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Http/Method/Put.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Http/Request.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Http/Response.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Http/Session.php';

/**
 * ユニットテスト基底クラス
 * @author Ryuichi TANAKA.
 * @since 2013/09/02
 * @version 0.4
 */
class TestBase extends \PHPUnit_Framework_TestCase
{
    use TestConstant;

    public function setUp()
    {
        $this->autoLoad();
        Logger::init($this->getLogConfigPath() . "/log.test.debug.ok.ini");
        $this->preloadClass();
    }

    public function tearDown()
    {
        Logger::finalize();
    }

    protected function autoLoad()
    {
        $classLoader = new \WebStream\Module\ClassLoader();
        spl_autoload_register([$classLoader, "load"]);
        register_shutdown_function('shutdownHandler');
    }

    protected function preloadClass()
    {
        $classLoader = new \WebStream\Module\ClassLoader();
        $classLoader->load([
            "WebStream\Annotation\Autowired",
            "WebStream\Annotation\Filter",
            "WebStream\Annotation\Template",
            "WebStream\Annotation\Header",
            "WebStream\Annotation\Query",
            "WebStream\Annotation\ExceptionHandler",
            "WebStream\Annotation\Database",
            "WebStream\Annotation\Validate",
            "WebStream\Annotation\Alias",
            "Doctrine\Common\Annotations\AnnotationException"
        ]);
    }
}
